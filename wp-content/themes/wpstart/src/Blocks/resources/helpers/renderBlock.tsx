import {FC} from 'react';
import domReady from '@wordpress/dom-ready';
import {createRoot} from '@wordpress/element';
import {BaseAttributes} from '@blocks/types/types';
import {getBlockScriptData} from '@blocks/helpers/getBlockScriptData';

/**
 * Render a block on the client side.
 *
 * @unreleased
 */
export const renderBlock = <A extends BaseAttributes, D = {}>(FrontendComponent: FC<A & D>): void => {
    const {root, data, getAttributes} = getBlockScriptData<A, D>();

    domReady(() => {
        const elements = document.querySelectorAll(`.${root}`);

        elements.forEach((element) => {
            const attributes = getAttributes(element.getAttribute('id'));
            const rootEl = createRoot(element);
            rootEl.render(<FrontendComponent {...attributes} {...data} />);
        });
    });
};
