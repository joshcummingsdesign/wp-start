import {Frontend} from './Frontend';

export default {
    title: 'Blocks/HelloWorld',
    component: Frontend,
    parameters: {
        layout: 'centered',
    },
    tags: ['autodocs'],
};

export const Default = {
    args: {
        blockId: '',
        className: '',
        ssr: false,
    },
};
