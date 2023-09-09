const defaultConfig = require('@wordpress/scripts/config/webpack.config.js');
const TsconfigPathsPlugin = require('tsconfig-paths-webpack-plugin');
const {getServerEntries} = require('./scripts/build/getServerEntries/getServerEntries');
const {themePath} = require('./scripts/build/themePath/themePath');
const path = require('path');

const serverConfig = {
    ...defaultConfig,
    resolve: {
        ...defaultConfig.resolve,
        plugins: [new TsconfigPathsPlugin()],
    },
    entry: {
        ...getServerEntries(),
    },
    output: {
        path: themePath(path.join('build', 'server')),
        publicPath: themePath(path.join('build', 'client', '/'), true, '/'),
    },
    plugins: [
        ...defaultConfig.plugins.filter((plugin) => plugin.constructor.name !== 'DependencyExtractionWebpackPlugin'),
    ],
};

module.exports = serverConfig;
