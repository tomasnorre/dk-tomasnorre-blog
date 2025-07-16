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
 