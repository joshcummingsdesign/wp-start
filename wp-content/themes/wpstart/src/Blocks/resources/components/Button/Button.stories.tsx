import {Button} from './Button';

export default {
    title: 'Components/Button',
    component: Button,
    parameters: {
        layout: 'centered',
    },
    tags: ['autodocs'],
};

export const Default = {
    args: {
        className: '',
        children: 'Button',
    },
};

export const Link = {
    args: {
        className: '',
        href: '#',
        children: 'Button',
    },
};

export const Text = {
    args: {
        className: '',
        variant: 'text',
        children: 'Button',
    },
};

export const Dark = {
    args: {
        className: '',
        href: '#',
        theme: 'dark',
        children: 'Button',
    },
};

export const Disabled = {
    args: {
        className: '',
        children: 'Button',
        disabled: true,
    },
};
