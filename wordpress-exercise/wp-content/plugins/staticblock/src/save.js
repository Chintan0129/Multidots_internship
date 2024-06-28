import { useBlockProps, RichText } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";

const Save = ({ attributes }) => {
	const { heading, subheading, paragraph, cards, paragraphColor } = attributes;

	return (
		<div {...useBlockProps.save()}>
			<h5 style={{ color: "grey", fontWeight: "bold" }}>
				<RichText.Content tagName="h5" value={subheading} />
			</h5>
			<h1 style={{ color: "darkblue", fontWeight: "800" }}>
				<RichText.Content tagName="h1" value={heading} />
			</h1>
			<p style={{ color: paragraphColor }}>
				<RichText.Content tagName="p" value={paragraph} />
			</p>
			<div
				className="cards"
				style={{ display: "flex", flexDirection: "row", gap: "20px" }}
			>
				{cards.map((card, index) => (
					<div className="card" key={index} style={{ margin: "10px" }}>
						{card.imageUrl && (
							<img
								src={card.imageUrl}
								alt={__("Card Image", "staticblock")}
								style={{ width: "300px", height: "300px" }}
							/>
						)}
						<RichText.Content
							tagName="h3"
							value={card.cardHeading}
							style={{ color: card.cardHeadingColor }}
						/>
						<RichText.Content
							tagName="h4"
							value={card.cardSubheading}
							style={{ color: card.cardSubheadingColor }}
						/>
						<RichText.Content tagName="p" value={card.cardDescription} />
					</div>
				))}
			</div>
		</div>
	);
};

export default Save;
