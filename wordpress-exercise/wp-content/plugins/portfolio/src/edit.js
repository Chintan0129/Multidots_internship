import { useState, useEffect } from "@wordpress/element";
import {
	CheckboxControl,
	PanelBody,
	PanelRow,
	Button,
} from "@wordpress/components";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";

const CustomEditComponent = ({ attributes, setAttributes, clientId }) => {
	const [portfolioProjects, setPortfolioProjects] = useState([]);
	const [categories, setCategories] = useState([]);
	const [selectedCategories, setSelectedCategories] = useState(
		new Set(attributes.selectedCategories || []),
	);
	const [clients, setClients] = useState([]);
	const [selectedClients, setSelectedClients] = useState(
		new Set(attributes.selectedClients || []),
	);
	const [selectedProject, setSelectedProject] = useState(null);
	const [isEditing, setIsEditing] = useState(false);

	useEffect(() => {
		fetch("/wordpress-exercise/wp-json/portfolio/v1/projects")
			.then((response) => response.json())
			.then((data) => {
				if (Array.isArray(data)) {
					setPortfolioProjects(data);
					const allCategories = new Set();
					const allClients = new Set();
					data.forEach((project) => {
						if (Array.isArray(project.category)) {
							project.category.forEach((cat) => allCategories.add(cat.name));
						}
						allClients.add(project.client);
					});
					setCategories([...allCategories]);
					setClients([...allClients]);
				} else {
					console.error("Invalid data format:", data);
				}
			})
			.catch((error) =>
				console.error("Error fetching portfolio projects:", error),
			);
	}, []);

	const handleCategoryChange = (category) => {
		const updatedCategories = new Set(selectedCategories);
		if (updatedCategories.has(category)) {
			updatedCategories.delete(category);
		} else {
			updatedCategories.add(category);
		}
		setSelectedCategories(updatedCategories);
		setAttributes({
			...attributes,
			selectedCategories: Array.from(updatedCategories),
		});
	};

	const handleClientChange = (client) => {
		const updatedClients = new Set(selectedClients);
		if (updatedClients.has(client)) {
			updatedClients.delete(client);
		} else {
			updatedClients.add(client);
		}
		setSelectedClients(updatedClients);
		setAttributes({
			...attributes,
			selectedClients: Array.from(updatedClients),
		});
	};

	const handleProjectClick = (project) => {
		setSelectedProject(project);
	};

	const handleDelete = () => {
		if (window.confirm("Are you sure you want to delete this block?")) {
			wp.data.dispatch("core/editor").removeBlocks([clientId]);
		}
	};

	const handleEdit = () => {
		if (isEditing) {
			setIsEditing(false);
		} else {
			wp.data.dispatch("core/block-editor").selectBlock(clientId);
			setIsEditing(true);
		}
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title="Portfolio Block Settings" initialOpen={true}>
					<PanelRow>
						<div className="portfolio-filter-container">
							<h2>Filter by Category:</h2>
							<div className="portfolio-checkbox-list">
								{categories.map((category, index) => (
									<CheckboxControl
										key={index}
										label={category}
										checked={selectedCategories.has(category)}
										onChange={() => handleCategoryChange(category)}
										className="portfolio-checkbox"
									/>
								))}
							</div>
						</div>
					</PanelRow>
					<PanelRow>
						<div className="portfolio-filter-container">
							<h2>Filter by Client:</h2>
							<div className="portfolio-checkbox-list">
								{clients.map((client, index) => (
									<CheckboxControl
										key={index}
										label={client}
										checked={selectedClients.has(client)}
										onChange={() => handleClientChange(client)}
										className="portfolio-checkbox"
									/>
								))}
							</div>
						</div>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()} className="custom-portfolio-block">
				<div className="portfolio-projects">
					{portfolioProjects.map((project, index) => {
						const isCategoryMatch =
							selectedCategories.size === 0 ||
							(Array.isArray(project.category) &&
								project.category.some((cat) =>
									selectedCategories.has(cat.name),
								));
						const isClientMatch =
							selectedClients.size === 0 || selectedClients.has(project.client);
						if (isCategoryMatch && isClientMatch) {
							return (
								<div
									key={index}
									className="portfolio-project"
									onClick={() => handleProjectClick(project)}
								>
									<div className="portfolio-thumbnail">
										{project.featured_image && (
											<img
												src={project.featured_image}
												alt={project.post_title}
												className="featured-image"
											/>
										)}
									</div>
									<div className="portfolio-content">
										<h3>{project.post_title}</h3>
									</div>
								</div>
							);
						}
						return null;
					})}
				</div>
				<Button onClick={handleEdit} className="edit-button">
					{isEditing ? "Save" : "Edit Block"}
				</Button>
				<Button onClick={handleDelete} className="delete-button">
					Delete Block
				</Button>
			</div>
		</>
	);
};

export default CustomEditComponent;
