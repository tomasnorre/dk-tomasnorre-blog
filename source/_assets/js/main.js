import '@fortawesome/fontawesome-free/js/all.min';

import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import Fuse from "fuse.js";
import Clipboard from "@ryangjchandler/alpine-clipboard"

window.Fuse = Fuse;
window.Alpine = Alpine;
Alpine.plugin(persist)
Alpine.plugin(Clipboard)
Alpine.start();

import hljs from 'highlight.js/lib/core';
import bash from 'highlight.js/lib/languages/bash';
import css from 'highlight.js/lib/languages/css';
import xml from 'highlight.js/lib/languages/xml';
import javascript from 'highlight.js/lib/languages/javascript';
import json from 'highlight.js/lib/languages/json';
import markdown from 'highlight.js/lib/languages/markdown';
import php from 'highlight.js/lib/languages/php';
import scss from 'highlight.js/lib/languages/scss';
import yaml from 'highlight.js/lib/languages/yaml';
import diff from 'highlight.js/lib/languages/diff';
import apache from 'highlight.js/lib/languages/apache';
import plaintext from 'highlight.js/lib/languages/plaintext';

hljs.registerLanguage('bash', bash);
hljs.registerLanguage('css', css);
hljs.registerLanguage('html', xml); // HTML = XML in highlight.js
hljs.registerLanguage('javascript', javascript);
hljs.registerLanguage('json', json);
hljs.registerLanguage('markdown', markdown);
hljs.registerLanguage('php', php);
hljs.registerLanguage('scss', scss);
hljs.registerLanguage('yaml', yaml);
hljs.registerLanguage('diff', diff);
hljs.registerLanguage('apacheconf', apache);
hljs.registerLanguage('txt', plaintext);

document.querySelectorAll('pre code').forEach((block) => {
    hljs.highlightElement(block); // Changed from highlightBlock to highlightElement in newer versions of highlight.js
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('pre').forEach((pre) => {
        if (pre.parentNode.classList.contains('code-wrapper')) return;

        // Create a wrapper container for positioning
        const wrapper = document.createElement('div');
        wrapper.className = 'relative code-wrapper';

        pre.parentNode.insertBefore(wrapper, pre);
        wrapper.appendChild(pre);

        // Create the copy button always visible
        const button = document.createElement('button');
        button.className = 'absolute top-3 right-3 p-1.5 text-gray-400 hover:text-gray-100 bg-gray-800/90 hover:bg-gray-700 rounded-md border border-gray-700/80 shadow-sm transition-colors duration-150 flex items-center justify-center';

        button.setAttribute('x-data', '{ copied: false }');
        button.setAttribute('@click', '$clipboard($el.parentElement.querySelector("code").innerText).then(() => { copied = true; setTimeout(() => copied = false, 2000); })');

        // FontAwesome slim icon markup
        button.innerHTML = `
            <i x-show="!copied" class="fa-regular fa-clipboard text-sm"></i>
            <i x-show="copied" class="fa-solid fa-clipboard-check text-emerald-400 text-sm"></i>
        `;

        wrapper.appendChild(button);

        // Initialize Alpine on the newly injected element tree
        if (window.Alpine) {
            window.Alpine.initTree(button);
        }
    });
});