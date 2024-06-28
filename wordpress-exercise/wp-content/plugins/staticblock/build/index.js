(()=>{"use strict";const e=window.wp.blocks,a=window.React,t=window.wp.blockEditor,r=window.wp.components,l=window.wp.i18n,c=JSON.parse('{"apiVersion":2,"name":"create-block/staticblock","title":"Static Block","category":"widgets","icon":"smiley","description":"A static block example.","supports":{"html":false},"attributes":{"heading":{"type":"string","source":"html","selector":"h1"},"subheading":{"type":"string","source":"html","selector":"h5"},"paragraph":{"type":"string","source":"html","selector":"p"},"cards":{"type":"array","default":[],"source":"query","selector":".card","query":{"imageUrl":{"type":"string","source":"attribute","attribute":"src","selector":"img"},"cardHeading":{"type":"string","source":"html","selector":"h3"},"cardSubheading":{"type":"string","source":"html","selector":"h4"},"cardDescription":{"type":"string","source":"html","selector":".card-description"},"cardHeadingColor":{"type":"string","default":""},"cardSubheadingColor":{"type":"string","default":""}}},"paragraphColor":{"type":"string","default":"black"}},"editorScript":"file:./index.js"}');(0,e.registerBlockType)(c.name,{...c,edit:({attributes:e,setAttributes:c})=>{const{heading:n,subheading:o,paragraph:i,cards:d,paragraphColor:s}=e,g=(e,a,t)=>{const r=[...d];r[e][a]=t,c({cards:r})},h=e=>{c({heading:e})},m=e=>{c({subheading:e})},p=e=>{c({paragraph:e})};return(0,a.createElement)("div",{...(0,t.useBlockProps)()},(0,a.createElement)(t.InspectorControls,null,(0,a.createElement)(r.PanelBody,{title:(0,l.__)("Block Settings"),initialOpen:!0},(0,a.createElement)(r.TextControl,{label:(0,l.__)("Heading"),value:n,onChange:h}),(0,a.createElement)(r.TextControl,{label:(0,l.__)("Subheading"),value:o,onChange:m}),(0,a.createElement)(r.TextControl,{label:(0,l.__)("Paragraph"),value:i,onChange:p}),(0,a.createElement)(t.ColorPalette,{label:(0,l.__)("Paragraph Color"),value:s,onChange:e=>c({paragraphColor:e})})),d.length>0&&(0,a.createElement)(r.PanelBody,{title:(0,l.__)("Card Settings"),initialOpen:!0},d.map(((e,n)=>(0,a.createElement)("div",{key:n},(0,a.createElement)("p",null,`Card ${n+1}`),(0,a.createElement)(t.ColorPalette,{label:(0,l.__)("Card Heading Color"),value:e.cardHeadingColor,onChange:e=>g(n,"cardHeadingColor",e)}),(0,a.createElement)(t.ColorPalette,{label:(0,l.__)("Card Subheading Color"),value:e.cardSubheadingColor,onChange:e=>g(n,"cardSubheadingColor",e)}),(0,a.createElement)(r.Button,{onClick:()=>(e=>{const a=[...d];a.splice(e,1),c({cards:a})})(n)},(0,l.__)("Clear Card","staticblock"))))))),(0,a.createElement)("div",{className:"block-content"},(0,a.createElement)("h5",{style:{color:"grey",fontWeight:"bold"}},(0,a.createElement)(t.RichText,{tagName:"h5",value:o,onChange:m,placeholder:(0,l.__)("Subheading","staticblock")})),(0,a.createElement)("h1",{style:{color:"blue",fontWeight:"800"}},(0,a.createElement)(t.RichText,{tagName:"h1",value:n,onChange:h,placeholder:(0,l.__)("Heading","staticblock")})),(0,a.createElement)("p",{style:{color:s}},(0,a.createElement)(t.RichText,{tagName:"p",value:i,onChange:p,placeholder:(0,l.__)("Paragraph","staticblock")})),(0,a.createElement)("div",{className:"cards",style:{display:"flex",flexDirection:"row"}},d.map(((e,c)=>(0,a.createElement)("div",{className:"card",key:c,style:{margin:"10px"}},(0,a.createElement)(t.MediaUploadCheck,null,(0,a.createElement)(t.MediaUpload,{onSelect:e=>((e,a)=>{g(e,"imageUrl",a.url)})(c,e),allowedTypes:["image"],value:e.imageUrl,render:({open:t})=>(0,a.createElement)(r.Button,{onClick:t},e.imageUrl?(0,a.createElement)("img",{src:e.imageUrl,alt:(0,l.__)("Card Image","staticblock"),style:{width:"100px",height:"100px"}}):(0,l.__)("Upload Image","staticblock"))})),(0,a.createElement)(t.RichText,{tagName:"h3",value:e.cardHeading,onChange:e=>g(c,"cardHeading",e),placeholder:(0,l.__)("Card Heading","staticblock"),style:{color:e.cardHeadingColor}}),(0,a.createElement)(t.RichText,{tagName:"h4",value:e.cardSubheading,onChange:e=>g(c,"cardSubheading",e),placeholder:(0,l.__)("Card Subheading","staticblock"),style:{color:e.cardSubheadingColor}}),(0,a.createElement)(r.TextControl,{label:(0,l.__)("Card Description"),value:e.cardDescription,onChange:e=>g(c,"cardDescription",e)}))))),d.length<3&&(0,a.createElement)(r.Button,{onClick:()=>{if(d.length<3){const e=[...d,{imageUrl:"",cardHeading:"",cardSubheading:"",cardDescription:"",cardHeadingColor:"",cardSubheadingColor:""}];c({cards:e})}}},(0,l.__)("Add Card","staticblock"))))},save:({attributes:e})=>{const{heading:r,subheading:c,paragraph:n,cards:o,paragraphColor:i}=e;return(0,a.createElement)("div",{...t.useBlockProps.save()},(0,a.createElement)("h5",{style:{color:"grey",fontWeight:"bold"}},(0,a.createElement)(t.RichText.Content,{tagName:"h5",value:c})),(0,a.createElement)("h1",{style:{color:"darkblue",fontWeight:"800"}},(0,a.createElement)(t.RichText.Content,{tagName:"h1",value:r})),(0,a.createElement)("p",{style:{color:i}},(0,a.createElement)(t.RichText.Content,{tagName:"p",value:n})),(0,a.createElement)("div",{className:"cards",style:{display:"flex",flexDirection:"row",gap:"20px"}},o.map(((e,r)=>(0,a.createElement)("div",{className:"card",key:r,style:{margin:"10px"}},e.imageUrl&&(0,a.createElement)("img",{src:e.imageUrl,alt:(0,l.__)("Card Image","staticblock"),style:{width:"300px",height:"300px"}}),(0,a.createElement)(t.RichText.Content,{tagName:"h3",value:e.cardHeading,style:{color:e.cardHeadingColor}}),(0,a.createElement)(t.RichText.Content,{tagName:"h4",value:e.cardSubheading,style:{color:e.cardSubheadingColor}}),(0,a.createElement)(t.RichText.Content,{tagName:"p",value:e.cardDescription}))))))}})})();