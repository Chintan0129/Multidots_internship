(()=>{"use strict";var e,t={820:()=>{const e=window.wp.blocks,t=window.React,o=window.wp.element,r=window.wp.components,l=window.wp.blockEditor,a=JSON.parse('{"UU":"create-block/custom-portfolio"}');(0,e.registerBlockType)(a.UU,{edit:({attributes:e,setAttributes:a,clientId:c})=>{const[n,s]=(0,o.useState)([]),[i,m]=(0,o.useState)([]),[d,p]=(0,o.useState)(new Set(e.selectedCategories||[])),[u,f]=(0,o.useState)([]),[h,k]=(0,o.useState)(new Set(e.selectedClients||[])),[w,b]=(0,o.useState)(null),[v,E]=(0,o.useState)(!1);return(0,o.useEffect)((()=>{fetch("/wordpress-exercise/wp-json/portfolio/v1/projects").then((e=>e.json())).then((e=>{if(Array.isArray(e)){s(e);const t=new Set,o=new Set;e.forEach((e=>{Array.isArray(e.category)&&e.category.forEach((e=>t.add(e.name))),o.add(e.client)})),m([...t]),f([...o])}else console.error("Invalid data format:",e)})).catch((e=>console.error("Error fetching portfolio projects:",e)))}),[]),(0,t.createElement)(t.Fragment,null,(0,t.createElement)(l.InspectorControls,null,(0,t.createElement)(r.PanelBody,{title:"Portfolio Block Settings",initialOpen:!0},(0,t.createElement)(r.PanelRow,null,(0,t.createElement)("div",{className:"portfolio-filter-container"},(0,t.createElement)("h2",null,"Filter by Category:"),(0,t.createElement)("div",{className:"portfolio-checkbox-list"},i.map(((o,l)=>(0,t.createElement)(r.CheckboxControl,{key:l,label:o,checked:d.has(o),onChange:()=>(t=>{const o=new Set(d);o.has(t)?o.delete(t):o.add(t),p(o),a({...e,selectedCategories:Array.from(o)})})(o),className:"portfolio-checkbox"})))))),(0,t.createElement)(r.PanelRow,null,(0,t.createElement)("div",{className:"portfolio-filter-container"},(0,t.createElement)("h2",null,"Filter by Client:"),(0,t.createElement)("div",{className:"portfolio-checkbox-list"},u.map(((o,l)=>(0,t.createElement)(r.CheckboxControl,{key:l,label:o,checked:h.has(o),onChange:()=>(t=>{const o=new Set(h);o.has(t)?o.delete(t):o.add(t),k(o),a({...e,selectedClients:Array.from(o)})})(o),className:"portfolio-checkbox"})))))))),(0,t.createElement)("div",{...(0,l.useBlockProps)(),className:"custom-portfolio-block"},(0,t.createElement)("div",{className:"portfolio-projects"},n.map(((e,o)=>{const r=0===d.size||Array.isArray(e.category)&&e.category.some((e=>d.has(e.name))),l=0===h.size||h.has(e.client);return r&&l?(0,t.createElement)("div",{key:o,className:"portfolio-project",onClick:()=>(e=>{b(e)})(e)},(0,t.createElement)("div",{className:"portfolio-thumbnail"},e.featured_image&&(0,t.createElement)("img",{src:e.featured_image,alt:e.post_title,className:"featured-image"})),(0,t.createElement)("div",{className:"portfolio-content"},(0,t.createElement)("h3",null,e.post_title))):null}))),(0,t.createElement)(r.Button,{onClick:()=>{v?E(!1):(wp.data.dispatch("core/block-editor").selectBlock(c),E(!0))},className:"edit-button"},v?"Save":"Edit Block"),(0,t.createElement)(r.Button,{onClick:()=>{window.confirm("Are you sure you want to delete this block?")&&wp.data.dispatch("core/editor").removeBlocks([c])},className:"delete-button"},"Delete Block")))}})}},o={};function r(e){var l=o[e];if(void 0!==l)return l.exports;var a=o[e]={exports:{}};return t[e](a,a.exports,r),a.exports}r.m=t,e=[],r.O=(t,o,l,a)=>{if(!o){var c=1/0;for(m=0;m<e.length;m++){for(var[o,l,a]=e[m],n=!0,s=0;s<o.length;s++)(!1&a||c>=a)&&Object.keys(r.O).every((e=>r.O[e](o[s])))?o.splice(s--,1):(n=!1,a<c&&(c=a));if(n){e.splice(m--,1);var i=l();void 0!==i&&(t=i)}}return t}a=a||0;for(var m=e.length;m>0&&e[m-1][2]>a;m--)e[m]=e[m-1];e[m]=[o,l,a]},r.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={57:0,350:0};r.O.j=t=>0===e[t];var t=(t,o)=>{var l,a,[c,n,s]=o,i=0;if(c.some((t=>0!==e[t]))){for(l in n)r.o(n,l)&&(r.m[l]=n[l]);if(s)var m=s(r)}for(t&&t(o);i<c.length;i++)a=c[i],r.o(e,a)&&e[a]&&e[a][0](),e[a]=0;return r.O(m)},o=globalThis.webpackChunkportfolio=globalThis.webpackChunkportfolio||[];o.forEach(t.bind(null,0)),o.push=t.bind(null,o.push.bind(o))})();var l=r.O(void 0,[350],(()=>r(820)));l=r.O(l)})();