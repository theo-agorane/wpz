export class SvgIcon {

	constructor(el) {
		const iconName = el.getAttribute('data-icon');
		const iconPath = iconsSvg + '#' + iconName;
		const use = document.createElementNS('http://www.w3.org/2000/svg', 'use');
		use.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', iconPath);
		el.innerHTML = '';
		el.appendChild(use);
	}
}

document.querySelectorAll('svg.svg-icon').forEach((el) => {
	new SvgIcon(el);
});
