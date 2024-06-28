import { useState, useEffect } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";

export default function Edit({ attributes, setAttributes }) {
	const [pages, setPages] = useState([]);
	const [loading, setLoading] = useState(true);
	const [error, setError] = useState(null);

	useEffect(() => {
		fetch("/wordpress-exercise/wp-json/wp/v2/pages")
			.then((response) => {
				if (!response.ok) {
					throw new Error("Failed to fetch pages");
				}
				return response.json();
			})
			.then((data) => {
				setPages(data);
				setLoading(false);
			})
			.catch((error) => {
				setError(error.message);
				setLoading(false);
			});
	}, []);

	const handlePageSelection = (pageId) => {
		const newSelectedPages = attributes.selectedPages.includes(pageId)
			? attributes.selectedPages.filter((id) => id !== pageId)
			: [...attributes.selectedPages, pageId];
		setAttributes({ selectedPages: newSelectedPages });
	};

	const handleCheckAll = () => {
		const allPageIds = pages.map((page) => page.id);
		setAttributes({ selectedPages: allPageIds });
	};

	const handleRemoveAll = () => {
		setAttributes({ selectedPages: [] });
	};

	return (
		<div {...useBlockProps()}>
			<div>
				<button onClick={handleCheckAll}>
					{__("Check All", "list-pages")}
				</button>
				<button onClick={handleRemoveAll}>
					{__("Remove All", "list-pages")}
				</button>
			</div>
			{loading ? (
				<p>{__("Loading pages...", "list-pages")}</p>
			) : error ? (
				<p>
					{__("Error:", "list-pages")} {error}
				</p>
			) : (
				<ul style={{ listStyle: "none", padding: 0 }}>
					{pages.map((page) => (
						<li key={page.id} style={{ fontWeight: "bold" }}>
							<input
								type="checkbox"
								checked={attributes.selectedPages.includes(page.id)}
								onChange={() => handlePageSelection(page.id)}
							/>
							{page.title.rendered}
						</li>
					))}
				</ul>
			)}
		</div>
	);
}
