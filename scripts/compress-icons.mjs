import imagemin from 'imagemin';
import imageminSvgo from 'imagemin-svgo';
import { outlineFile, outlineSvg } from '@davestewart/outliner';
import fs from 'fs';
import { optimize as svgOptimize } from 'svgo';
import { parseSvg } from 'svgo/lib/parser.js';
import { stringifySvg } from 'svgo/lib/stringifier.js';

const theme = 		'./www/wp-content/themes/wpz';
const iconsSrc = 	`${theme}/assets/icons/*.svg`;
const logosSrc = 	`${theme}/assets/icons/logos/*.svg`;
const iconsDist = 	`${theme}/dist/icons/`;

/*
const logos = await imagemin([logosSrc], {
	destination: iconsDist,
	plugins: [
		imageminSvgo({
			plugins: [{
				name: 'removeViewBox',
				active: false,
			}],
		}),
	],
});
*/

const icons = await imagemin([iconsSrc], {
	destination: iconsDist,
	plugins: [],
});

fs.readdir(iconsDist, (errDir, files) => {
	files.forEach(file => {
		const svgPath = `${iconsDist}${file}`;

		fs.readFile(svgPath, (errFile, baseSvg) => {
			const optimizedSvg = svgOptimize(baseSvg, {
				path: svgPath,
				plugins: [
					{
						"name": "convertShapeToPath",
						"params": { convertArcs: true },
					},
					{
						"name": "collapseGroups",
						"params": {},
					},
					{
						"name": "removeStyleElement",
						"params": {},
					},
				],
			});

			let svg = parseSvg(optimizedSvg.data);

			for (var i in svg.children) {
				if (svg.children[i].name == 'svg') {
					let attributes = {};

					for (var attr in svg.children[i].attributes) {
						if (attr.indexOf('fill') === 0 || attr.indexOf('stroke') === 0) {
							attributes[attr] = svg.children[i].attributes[attr];
						}
					}

					delete svg.children[i].attributes.class;
					for (var attr in attributes) {
						delete svg.children[i].attributes[attr];
					}

					for (var j in svg.children[i].children) {
						svg.children[i].children[j].attributes = {
							...svg.children[i].children[j].attributes,
							...attributes,
						};
					}
				}
			}

			fs.writeFile(svgPath, stringifySvg(svg), (err) => {
				
			});
		});
	});
});
