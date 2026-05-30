export const email = {
    form: () => ({
        url: '/forgot-password',
        method: 'post' as const,
    }),
};

export const update = {
    form: () => ({
        url: '/reset-password',
        method: 'post' as const,
    }),
};

export const request = (): string => '/forgot-password';
