export default {
    plugins: [
        'prettier-plugin-blade',
        '@prettier/plugin-php',
        'prettier-plugin-tailwindcss',
    ],
    overrides: [
        {
            files: '*.blade.php',
            options: {
                parser: 'blade',
            },
        },
    ],
    printWidth: 120,
    singleQuote: true,
    tabWidth: 4,
    trailingComma: 'all',
};
