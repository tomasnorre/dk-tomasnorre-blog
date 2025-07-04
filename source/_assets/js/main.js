import axios from 'axios';
window.axios = axios;

import Alpine from "alpinejs";
import Fuse from "fuse.js";

window.Fuse = Fuse;
window.Alpine = Alpine;
Alpine.start();

import hljs from 'highlight.js/lib/core';
import 'highlight.js/styles/default.css';
import 'boxicons';

hljs.registerLanguage('bash', require('highlight.js/lib/languages/bash'));
hljs.registerLanguage('css', require('highlight.js/lib/languages/css'));
hljs.registerLanguage('html', require('highlight.js/lib/languages/xml'));
hljs.registerLanguage('javascript', require('highlight.js/lib/languages/javascript'));
hljs.registerLanguage('json', require('highlight.js/lib/languages/json'));
hljs.registerLanguage('markdown', require('highlight.js/lib/languages/markdown'));
hljs.registerLanguage('php', require('highlight.js/lib/languages/php'));
hljs.registerLanguage('scss', require('highlight.js/lib/languages/scss'));
hljs.registerLanguage('yaml', require('highlight.js/lib/languages/yaml'));
hljs.registerLanguage('diff', require('highlight.js/lib/languages/diff'));
hljs.registerLanguage('apacheconf', require('highlight.js/lib/languages/apache'));
hljs.registerLanguage('txt', require('highlight.js/lib/languages/plaintext'));

document.querySelectorAll('pre code').forEach((block) => {
    hljs.highlightElement(block); // Changed from highlightBlock to highlightElement in newer versions of highlight.js
});
