import imagemin from 'imagemin';
import imageminJpegtran from 'imagemin-jpegtran';
import imageminPngquant from 'imagemin-pngquant';
import imageminSvgo from 'imagemin-svgo';
import imageminGifsicle from 'imagemin-gifsicle';

const theme = 		'./www/wp-content/themes/wpz';
const imagesSrc = 	`${theme}/assets/img/**/*.{jpg,JPG,jpeg,JPEG,png,svg,gif,ico}`;
const imagesDist = 	`${theme}/dist/img/`;
const iconsSrc = 	`${theme}/assets/icons/**/*.svg`;
const iconsDist = 	`${theme}/dist/icons/`;

const images = await imagemin([imagesSrc], {
	destination: imagesDist,
	preserveDirectories: true,
	plugins: [
		imageminJpegtran({
			quality: [0.7, 0.9],
		}),
		imageminPngquant({
			quality: [0.7, 0.9],
		}),
		imageminSvgo({
			plugins: [{
				name: 'removeViewBox',
				active: false,
			}],
		}),
		imageminGifsicle(),
	],
});
