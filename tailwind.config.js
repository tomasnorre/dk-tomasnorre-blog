module.exports = {
    purge: {
        content: [
            'source/**/*.html',
            'source/**/*.md',
            'source/**/*.js',
            'source/**/*.php',
            'source/**/*.vue',
        ],
        options: {
            whitelist: [
                /language/,
                /hljs/,
                /mce/,
            ],
        },
    },
    theme: {
        extend: {
            fontFamily: {
                sans: [
                    'NunitoSans'
                ],
                mono: [
                    'JetBrainsMono',
                ],
            },
            lineHeight: {
                normal: '1.6',
                loose: '1.75',
            },
            maxWidth: {
                none: 'none',
                '7xl': '80rem',
                '8xl': '88rem'
            },
            spacing: {
                '7': '1.75rem',
                '9': '2.25rem',
                '1/2': '50%',
                '1/3': '33.333333%',
                '2/3': '66.666667%',
                '1/4': '25%',
                '2/4': '50%',
                '3/4': '75%',
                '1/5': '20%',
                '2/5': '40%',
                '3/5': '60%',
                '4/5': '80%',
                '1/6': '16.666667%',
                '2/6': '33.333333%',
                '3/6': '50%',
                '4/6': '66.666667%',
                '5/6': '83.333333%',
                '1/12': '8.333333%',
                '2/12': '16.666667%',
                '3/12': '25%',
                '4/12': '33.333333%',
                '5/12': '41.666667%',
                '6/12': '50%',
                '7/12': '58.333333%',
                '8/12': '66.666667%',
                '9/12': '75%',
                '10/12': '83.333333%',
                '11/12': '91.666667%',
            },
            boxShadow: {
                'lg': '0 -1px 27px 0 rgba(0, 0, 0, 0.04), 0 4px 15px 0 rgba(0, 0, 0, 0.08)',
            }
        },
        fontSize: {
            'xs': '.8rem',
            'sm': '.925rem',
            'base': '1rem',
            'lg': '1.125rem',
            'xl': '1.25rem',
            '2xl': '1.5rem',
            '3xl': '1.75rem',
            '4xl': '2.125rem',
            '5xl': '2.625rem',
            '6xl': '10rem',
        },
        colors: {
            'bg-main': 'var(--color-bg-main)',
            'bg-card': 'var(--color-bg-card)',
            'link': 'var(--color-link)',
            'link-hover': 'var(--color-link-link)',
            'text': 'var(--color-text)',
        },
    },
    variants: {
        borderRadius: ['responsive', 'focus'],
        borderWidth: ['responsive', 'active', 'focus'],
        width: ['responsive', 'focus']
    },
    plugins: [
        function ({addUtilities}) {
            const newUtilities = {
                '.transition-fast': {
                    transition: 'all .2s ease-out',
                },
                '.transition': {
                    transition: 'all .5s ease-out',
                },
            }
            addUtilities(newUtilities)
        }
    ]
}
