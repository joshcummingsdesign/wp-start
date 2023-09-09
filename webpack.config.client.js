const path = require('path');
const defaultConfig = require('@wordpress/scripts/config/webpack.config.js');
const TsconfigPathsPlugin = require('tsconfig-paths-webpack-plugin');
const {getBlockEntries} = require('./scripts/build/getBlockEntries/getBlockEntries');
const {getResourceEntries} = require('./scripts/build/getResourceEntries/getResourceEntries');
const {themePath} = require('./scripts/build/themePath/themePath');

const isProduction = process.env.NODE_ENV === 'production';

const clientConfig = {
    ...defaultConfig,
    resolve: {
        ...defaultConfig.resolve,
        plugins: [new TsconfigPathsPlugin()],
    },
    entry: {
        ...getResourceEntries(),
        ...getBlockEntries(),
    },
    output: {
        path: themePath(path.join('build', 'client')),
    },
};

if (!isProduction) {
    clientConfig.devServer = {
        devMiddleware: {
            writeToDisk: true,
        },
        hot: true,
        allowedHosts: 'all',
        host: 'localhost',
        port: 8887,
    };

    clientConfig.optimization = {
        ...defaultConfig.optimization,
        runtimeChunk: 'single',
    };

    clientConfig.plugins = [
        ...defaultConfig.plugins.filter((plugin) => plugin.constructor.name !== 'CleanWebpackPlugin'),
    ];
}

module.exports = clientConfig;
