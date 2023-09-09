import {useCallback} from '@wordpress/element';
import {InnerBlocks} from '@wordpress/block-editor';
import {useSelect} from '@wordpress/data';

/**
 * Use a custom appender for InnerBlocks with a limited repeat (defaults to 1).
 *
 * ```
 * const appender = useAppender(clientId);
 * ```
 * ```
 * <InnerBlocks allowedBlocks={['core/paragraph']} renderAppender={appender} />
 * ```
 *
 * @unreleased
 */
export const useAppender = (clientId: string, limit: number = 1): (() => JSX.Element | false) => {
    const innerBlockCount = useSelect(
        (select) => (select('core/block-editor') as any).getBlock(clientId).innerBlocks,
        [clientId]
    );

    return useCallback(() => {
        if (innerBlockCount.length < limit) {
            return <InnerBlocks.ButtonBlockAppender />;
        }

        return false;
    }, [innerBlockCount]);
};
