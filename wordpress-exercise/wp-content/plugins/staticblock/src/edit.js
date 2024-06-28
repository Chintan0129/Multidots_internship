import {
	useBlockProps,
	RichText,
	InspectorControls,
	ColorPalette,
	MediaUpload,
	MediaUploadCheck,
} from "@wordpress/block-editor";
import { Button, PanelBody, TextControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

const Edit = ({ attributes, setAttributes }) => {
	const { heading, subheading, paragraph, cards, paragraphColor } = attributes;

	const addCard = () => {
		if (cards.length < 3) {
			const newCards = [
				...cards,
				{
					imageUrl: "",
					cardHeading: "",
					cardSubheading: "",
					cardDescription: "",
					cardHeadingColor: "",
					cardSubheadingColor: "",
				},
			];
			setAttributes({ cards: newCards });
		}
	};

	const updateCard = (index, field, value) => {
		const newCards = [...cards];
		newCards[index][field] = value;
		setAttributes({ cards: newCards });
	};

	const onSelectImage = (index, media) => {
		updateCard(index, "imageUrl", media.url);
	};

	const onChangeHeading = (value) => {
		setAttributes({ heading: value });
	};

	const onChangeSubheading = (value) => {
		setAttributes({ subheading: value });
	};

	const onChangeParagraph = (value) => {
		setAttributes({ paragraph: value });
	};

	const removeCard = (index) => {
		const newCards = [...cards];
		newCards.splice(index, 1);
		setAttributes({ cards: newCards });
	};

	return (
		<div {...useBlockProps()}>
			<InspectorControls>
				<PanelBody title={__("Block Settings")} initialOpen={true}>
					<TextControl
						label={__("Heading")}
						value={heading}
						onChange={onChangeHeading}
					/>
					<TextControl
						label={__("Subheading")}
						value={subheading}
						onChange={onChangeSubheading}
					/>
					<TextControl
						label={__("Paragraph")}
						value={paragraph}
						onChange={onChangeParagraph}
					/>
					<ColorPalette
						label={__("Paragraph Color")}
						value={paragraphColor}
						onChange={(color) => setAttributes({ paragraphColor: color })}
					/>
				</PanelBody>
				{cards.length > 0 && (
					<PanelBody title={__("Card Settings")} initialOpen={true}>
						{cards.map((card, index) => (
							<div key={index}>
								<p>{`Card ${index + 1}`}</p>
								<ColorPalette
									label={__("Card Heading Color")}
									value={card.cardHeadingColor}
									onChange={(color) =>
										updateCard(index, "cardHeadingColor", color)
									}
								/>
								<ColorPalette
									label={__("Card Subheading Color")}
									value={card.cardSubheadingColor}
									onChange={(color) =>
										updateCard(index, "cardSubheadingColor", color)
									}
								/>
								<Button onClick={() => removeCard(index)}>
									{__("Clear Card", "staticblock")}
								</Button>
							</div>
						))}
					</PanelBody>
				)}
			</InspectorControls>
			<div className="block-content">
				<h5 style={{ color: "grey", fontWeight: "bold" }}>
					<RichText
						tagName="h5"
						value={subheading}
						onChange={onChangeSubheading}
						placeholder={__("Subheading", "staticblock")}
					/>
				</h5>
				<h1 style={{ color: "blue", fontWeight: "800" }}>
					<RichText
						tagName="h1"
						value={heading}
						onChange={onChangeHeading}
						placeholder={__("Heading", "staticblock")}
					/>
				</h1>
				<p style={{ color: paragraphColor }}>
					<RichText
						tagName="p"
						value={paragraph}
						onChange={onChangeParagraph}
						placeholder={__("Paragraph", "staticblock")}
					/>
				</p>
				<div
					className="cards"
					style={{ display: "flex", flexDirection: "row" }}
				>
					{cards.map((card, index) => (
						<div className="card" key={index} style={{ margin: "10px" }}>
							<MediaUploadCheck>
								<MediaUpload
									onSelect={(media) => onSelectImage(index, media)}
									allowedTypes={["image"]}
									value={card.imageUrl}
									render={({ open }) => (
										<Button onClick={open}>
											{!card.imageUrl ? (
												__("Upload Image", "staticblock")
											) : (
												<img
													src={card.imageUrl}
													alt={__("Card Image", "staticblock")}
													style={{ width: "100px", height: "100px" }}
												/>
											)}
										</Button>
									)}
								/>
							</MediaUploadCheck>
							<RichText
								tagName="h3"
								value={card.cardHeading}
								onChange={(value) => updateCard(index, "cardHeading", value)}
								placeholder={__("Card Heading", "staticblock")}
								style={{ color: card.cardHeadingColor }}
							/>
							<RichText
								tagName="h4"
								value={card.cardSubheading}
								onChange={(value) => updateCard(index, "cardSubheading", value)}
								placeholder={__("Card Subheading", "staticblock")}
								style={{ color: card.cardSubheadingColor }}
							/>

							<TextControl
								label={__("Card Description")}
								value={card.cardDescription}
								onChange={(value) =>
									updateCard(index, "cardDescription", value)
								}
							/>
						</div>
					))}
				</div>
				{cards.length < 3 && (
					<Button onClick={addCard}>{__("Add Card", "staticblock")}</Button>
				)}
			</div>
		</div>
	);
};

export default Edit;
