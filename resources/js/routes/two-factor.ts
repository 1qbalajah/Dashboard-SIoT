export const show = {
    url: (): string => '/settings/two-factor',
};

export const enable = {
    form: () => ({
        url: '/user/two-factor-authentication',
        method: 'post' as const,
    }),
};

export const disable = {
    form: () => ({
        url: '/user/two-factor-authentication',
        method: 'delete' as const,
    }),
};

export const qrCode = {
    url: (): string => '/user/two-factor-qr-code',
};

export const secretKey = {
    url: (): string => '/user/two-factor-secret-key',
};

export const recoveryCodes = {
    url: (): string => '/user/two-factor-recovery-codes',
};
