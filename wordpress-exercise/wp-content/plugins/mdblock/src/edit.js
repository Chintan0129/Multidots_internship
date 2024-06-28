import { useState, useEffect } from "@wordpress/element";
import { CheckboxControl, Button, IconButton } from "@wordpress/components";
import { useBlockProps } from "@wordpress/block-editor";
import { chevronDown, chevronUp } from "@wordpress/icons";

const CustomEditComponent = ({ attributes, setAttributes, clientId }) => {
	const [faqData, setFaqData] = useState([]);
	const [categories, setCategories] = useState([]);
	const [selectedCategories, setSelectedCategories] = useState([]);
	const [tags, setTags] = useState([]);
	const [selectedTags, setSelectedTags] = useState([]);
	const [selectedFAQs, setSelectedFAQs] = useState([]);
	const [isPlaceholderVisible, setIsPlaceholderVisible] = useState(true);
	const [isNextStep, setIsNextStep] = useState(false);
	const [filteredFAQs, setFilteredFAQs] = useState([]);
	const [expandedFAQ, setExpandedFAQ] = useState(null);

	useEffect(() => {
		// Fetch FAQ data from custom API endpoint
		fetch("/wordpress-exercise/wp-json/custom-faq/v1/data")
			.then((response) => response.json())
			.then((data) => {
				// Set FAQ data in state
				setFaqData(data);
				// Extract categories and tags
				const allCategories = new Set();
				const allTags = new Set();
				data.forEach((faq) => {
					faq.category.forEach((cat) => allCategories.add(cat.name));
					faq.tags.forEach((tag) => allTags.add(tag));
				});
				setCategories([...allCategories]);
				setTags([...allTags]);
			})
			.catch((error) => {
				console.error("Error fetching FAQ data:", error);
			});
	}, []);

	const handleCategoryChange = (category) => {
		// Toggle the selected category
		const updatedCategories = selectedCategories.includes(category)
			? selectedCategories.filter((cat) => cat !== category)
			: [...selectedCategories, category];
		setSelectedCategories(updatedCategories);
	};

	const handleTagChange = (tag) => {
		// Toggle the selected tag
		const updatedTags = selectedTags.includes(tag)
			? selectedTags.filter((t) => t !== tag)
			: [...selectedTags, tag];
		setSelectedTags(updatedTags);
	};

	const handleNextStep = () => {
		const filtered = faqData.filter(
			(faq) =>
				(selectedCategories.length === 0 ||
					faq.category.some((cat) => selectedCategories.includes(cat.name))) &&
				(selectedTags.length === 0 ||
					selectedTags.some((tag) => faq.tags.includes(tag))),
		);
		setFilteredFAQs(filtered);
		setIsNextStep(true);
	};

	const handleFAQSelection = (faq) => {
		const updatedSelectedFAQs = selectedFAQs.includes(faq)
			? selectedFAQs.filter((selected) => selected.id !== faq.id)
			: [...selectedFAQs, faq];
		setSelectedFAQs(updatedSelectedFAQs);
	};

	const handleDone = () => {
		setAttributes({
			questionsAndAnswers: selectedFAQs,
		});
		setIsPlaceholderVisible(false);
		setIsNextStep(false);
	};

	const handleEdit = () => {
		setIsNextStep(true);
	};

	const toggleAnswer = (faqId) => {
		setExpandedFAQ(expandedFAQ === faqId ? null : faqId);
	};

	// Function to handle block deletion
	const handleDelete = () => {
		if (window.confirm("Are you sure you want to delete this block?")) {
			wp.data.dispatch("core/editor").removeBlocks([clientId]);
		}
	};

	// Function to handle placeholder click
	const handlePlaceholderClick = () => {
		setIsPlaceholderVisible(false);
	};

	return (
		<div {...useBlockProps()} className="custom-faq-block">
			{isPlaceholderVisible ? (
				<div className="placeholder" onClick={handlePlaceholderClick}>
					<button className="plus-icon-button">+</button>
					<p>Click to start using FAQ block</p>
				</div>
			) : (
				<>
					{!isNextStep ? (
						<>
							<div className="filters-container">
								<div className="filter-section">
									<h2>Filter by Category:</h2>
									{categories.map((cat, index) => (
										<CheckboxControl
											key={index}
											label={cat}
											checked={selectedCategories.includes(cat)}
											onChange={() => handleCategoryChange(cat)}
											className="filter-checkbox"
										/>
									))}
								</div>
								<div className="filter-section">
									<h2>Filter by Tag:</h2>
									{tags.map((tag, index) => (
										<CheckboxControl
											key={index}
											label={tag}
											checked={selectedTags.includes(tag)}
											onChange={() => handleTagChange(tag)}
											className="filter-checkbox"
										/>
									))}
								</div>
							</div>
							<Button
								onClick={handleNextStep}
								isPrimary
								className="next-button"
							>
								Next
							</Button>
						</>
					) : (
						<>
							<h2>Questions & Answers:</h2>
							<ul className="faq-list">
								{filteredFAQs.map((faq) => (
									<li key={faq.id} className="faq-item">
										<CheckboxControl
											label={faq.question}
											checked={selectedFAQs.includes(faq)}
											onChange={() => handleFAQSelection(faq)}
											className="faq-checkbox"
										/>
									</li>
								))}
							</ul>
							<Button onClick={handleDone} isPrimary className="done-button">
								Done
							</Button>
						</>
					)}

					{!isPlaceholderVisible &&
						attributes.questionsAndAnswers.length > 0 && (
							<>
								<h2>Selected Questions & Answers:</h2>
								<ul className="selected-faq-list">
									{attributes.questionsAndAnswers.map((faq) => (
										<li key={faq.id} className="faq-item">
											<div className="question-container">
												<h3 className="question">{faq.question}</h3>
												<IconButton
													icon={
														expandedFAQ === faq.id ? chevronUp : chevronDown
													}
													onClick={() => toggleAnswer(faq.id)}
													label="Toggle Answer"
													className="toggle-icon"
												/>
											</div>
											{expandedFAQ === faq.id && (
												<p className="answer">{faq.answer}</p>
											)}
										</li>
									))}
								</ul>
								<Button onClick={handleEdit} className="edit-button">
									Edit
								</Button>
							</>
						)}

					{/* Delete block button */}
					<Button
						onClick={handleDelete}
						className="delete-button"
						isDestructive
					>
						Delete Block
					</Button>
				</>
			)}
		</div>
	);
};

export default CustomEditComponent;
