import { registerBlockType } from "@wordpress/blocks";
import "./style.scss";
import Edit from "./edit"; // Import the edit.js file
import metadata from "./block.json";

registerBlockType(metadata.name, {
	edit: Edit, // Use the Edit component from edit.js for editing interface
});
