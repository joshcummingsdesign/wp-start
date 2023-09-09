import {BaseAttributes} from '@blocks/types/types';

/**
 * Get the block's script data.
 *
 * Returns { root, data, getAttributes }
 *
 * `root`: The ID of the root element for React bootstrapping.
 *
 * `data`: The data injected into the global window object by the block.
 *
 * `getAttributes`: A function that retrieves the block attributes by `blockId`.
 *
 * @unreleased
 */
export const getBlockScriptData = <A extends BaseAttributes, D = {}>(): {
    root: string;
    data: D;
    getAttributes: (id: string) => A;
} => {
    const {app} = window as any;
    const root: string = app.root;
    const data: D = app.data;

    const getAttributes = <A>(blockId: string): A => {
        const id = blockId.replaceAll('-', '_');
        return (window as any)[id];
    };

    return {root, data, getAttributes};
};
