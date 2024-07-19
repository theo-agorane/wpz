const compressImages = require('compress-images');
const theme = './www/wp-content/themes/wpz';
const imagesSrc = `${theme}/assets/img/**/*.{jpg,JPG,jpeg,JPEG,png,svg,gif,ico}`;
const imagesDist = `${theme}/dist/img/`;
const iconsSrc = `${theme}/assets/icons/**/*.svg`;
const iconsDist = `${theme}/dist/icons/`;

compressImages(
    imagesSrc,
    imagesDist,
    {
        compress_force: false,
        statistic: true,
        autoupdate: true
    },
    false,
    { jpg: { engine: 'mozjpeg', command: ['-quality', '60'] } },
    { png: { engine: 'pngquant', command: ['--quality=20-50', '-o'] } },
    { svg: { engine: 'svgo', command: '--multipass' } },
    { gif: { engine: 'gifsicle', command: ['--colors', '64', '--use-col=web'] } },
    function() { }
);

compressImages(
    iconsSrc,
    iconsDist,
    {
        compress_force: false,
        statistic: true,
        autoupdate: true
    },
    false,
    { jpg: { engine: 'mozjpeg', command: ['-quality', '60'] } },
    { png: { engine: 'pngquant', command: ['--quality=20-50', '-o'] } },
    { svg: { engine: 'svgo', command: '--multipass' } },
    { gif: { engine: 'gifsicle', command: ['--colors', '64', '--use-col=web'] } },
    function() { }
);