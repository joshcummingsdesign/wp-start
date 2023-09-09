import React, {AnchorHTMLAttributes, DetailedHTMLProps} from 'react';
import {forwardRef, useCallback} from '@wordpress/element';
import {buildClassNames} from '@blocks/helpers/buildClassNames';
import {combineClassNames as css} from '@blocks/helpers/combineClassNames';
import './styles.scss';

interface Props {
    ref?: any;
    variant?: 'default' | 'link' | 'text';
    theme?: 'light' | 'dark';
    disabled?: boolean;
}

type AnchorProps = DetailedHTMLProps<AnchorHTMLAttributes<HTMLAnchorElement>, HTMLAnchorElement>;

export type ButtonProps = Props & AnchorProps & React.ButtonHTMLAttributes<HTMLButtonElement>;

const classNames = ['text'] as const;

type ClassNames = Record<(typeof classNames)[number], string>;

const s = buildClassNames<ClassNames>('wpstart-button', classNames);

/**
 * The button text component.
 *
 * @unreleased
 */
const ButtonText = forwardRef<any, ButtonProps>(({className, theme, disabled, children, ...props}, ref) => (
    <span ref={ref} className={css(s.root, className, 'text', theme, disabled && 'disabled')} {...props}>
        <span className={s.text}>{children}</span>
    </span>
));

/**
 * The button link component.
 *
 * @unreleased
 */
const ButtonLink = forwardRef<any, ButtonProps>(({className, theme, disabled, children, ...props}, ref) => {
    const handleClick = useCallback(
        (e: React.MouseEvent<HTMLAnchorElement>) => {
            if (disabled) {
                e.preventDefault();
            }
        },
        [disabled]
    );

    return (
        <a
            ref={ref}
            className={css(s.root, className, 'link', theme, disabled && 'disabled')}
            onClick={handleClick}
            {...props}
        >
            <span className={s.text}>{children}</span>
        </a>
    );
});

/**
 * The button default component.
 *
 * @unreleased
 */
const ButtonDefault = forwardRef<any, ButtonProps>(({className, theme, disabled, children, ...props}, ref) => (
    <button
        ref={ref}
        className={css(s.root, className, 'link', theme, disabled && 'disabled')}
        disabled={disabled}
        {...props}
    >
        <span className={s.text}>{children}</span>
    </button>
));

/**
 * The button component.
 *
 * @unreleased
 */
export const Button = forwardRef<any, ButtonProps>(
    ({variant = 'default', theme = 'light', disabled = false, children, ...props}, ref) => {
        if (variant === 'text') {
            return (
                <ButtonText ref={ref} theme={theme} disabled={disabled} {...props}>
                    {children}
                </ButtonText>
            );
        }

        if (variant === 'link' || !!props.href) {
            return (
                <ButtonLink
                    ref={ref}
                    theme={theme}
                    disabled={disabled}
                    role="button"
                    aria-disabled={disabled}
                    {...props}
                >
                    {children}
                </ButtonLink>
            );
        }

        return (
            <ButtonDefault ref={ref} theme={theme} disabled={disabled} {...props}>
                {children}
            </ButtonDefault>
        );
    }
);
