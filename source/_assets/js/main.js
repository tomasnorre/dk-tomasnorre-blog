import axios from 'axios';
window.axios = axios;

import { createApp } from 'vue';

import Search from './components/Search.vue';
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

document.querySelectorAll('pre code').forEach((block) => {
    hljs.highlightElement(block); // Changed from highlightBlock to highlightElement in newer versions of highlight.js
});

const app = createApp({
    components: {
        Search,
    }
});

app.mount('#vue-search');
