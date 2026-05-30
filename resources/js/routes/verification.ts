export const send = {
    url: (): string => '/email/verification-notification',
    form: () => ({
        url: '/email/verification-notification',
        method: 'post' as const,
    }),
};
