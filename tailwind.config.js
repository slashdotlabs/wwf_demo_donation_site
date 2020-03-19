module.exports = {
    theme: {
        extend: {
            spacing: {
                '24': '6rem',
                '26': '6.5rem'
            },
            colors: {
                'footer-gray': '#393939',
            }

        }
    },
    variants: {},
    plugins: [
        require('@tailwindcss/ui'),
    ]
};
