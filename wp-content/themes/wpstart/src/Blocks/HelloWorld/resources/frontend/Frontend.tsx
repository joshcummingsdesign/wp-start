import React, {useState} from 'react';
import apiFetch from '@wordpress/api-fetch';
import {addQueryArgs} from '@wordpress/url';
import {useCallback} from '@wordpress/element';
import {buildClassNames} from '@blocks/helpers/buildClassNames';
import {Button} from '@blocks/components/Button/Button';
import {combineClassNames as css} from '@blocks/helpers/combineClassNames';
import {BlockAttributes, BlockData} from '../types/types';
import './styles.scss';

type Props = BlockAttributes & BlockData;

const classNames = ['heading', 'form'] as const;

type ClassNames = Record<(typeof classNames)[number], string>;

const s = buildClassNames<ClassNames>('wpstart-hello-world', classNames);

/**
 * The hello world block.
 *
 * @unreleased
 */
export const Frontend = ({className}: Props) => {
    const [name, setName] = useState<string>('');
    const [greeting, setGreeting] = useState<string>('Hello world');

    const handleSubmit = useCallback(
        async (e: React.FormEvent<HTMLFormElement>): Promise<void> => {
            e.preventDefault();
            if (!name) return;

            const res = await apiFetch<string>({path: addQueryArgs('wpstart/v1/greeting', {name})});
            setGreeting(res);
        },
        [name]
    );

    const handleChange = useCallback((e: React.FormEvent<HTMLInputElement>): void => {
        setName(e.currentTarget.value);
    }, []);

    return (
        <div className={css(s.root, className)}>
            <h1 className={s.heading}>{greeting}</h1>
            <form className={s.form} onSubmit={handleSubmit}>
                <input type="text" value={name} onChange={handleChange} />
                <Button>Welcome</Button>
            </form>
        </div>
    );
};
