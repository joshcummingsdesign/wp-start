const path = require('path');
const MiniCSSExtractPlugin = require('mini-css-extract-plugin');
const TsconfigPathsPlugin = require('tsconfig-paths-webpack-plugin');
const clientConfig = require('../webpack.config.client');
const {themePath} = require('../scripts/build/themePath/themePath');

/** @type { import('@storybook/react-webpack5').StorybookConfig } */
const config = {
    stories: [themePath('src/Blocks/**/*.mdx'), themePath('src/Blocks/**/*.stories.@(js|jsx|mjs|ts|tsx)')],
    addons: [
        '@storybook/addon-links',
        '@storybook/addon-essentials',
        '@storybook/addon-onboarding',
        '@storybook/addon-interactions',
    ],
    framework: {
        name: '@storybook/react-webpack5',
        options: {},
    },
    docs: {
        autodocs: 'tag',
    },
    webpackFinal: async (config) => ({
        ...config,
        resolve: {
            ...config.resolve,
            plugins: [...(config.resolve.plugins || []), new TsconfigPathsPlugin()],
        },
        module: {
            ...config.module,
            rules: [
                ...config.module.rules,
                ...clientConfig.module.rules.map((rule) => {
                    if (rule.test.toString() === /\.css$/.toString()) {
                        rule.include = [path.resolve(__dirname, 'not_exist_path')];
                    }
                    return rule;
                }),
            ],
        },
        plugins: [...config.plugins, new MiniCSSExtractPlugin({filename: '[name].css'})],
    }),
};
export default config;
