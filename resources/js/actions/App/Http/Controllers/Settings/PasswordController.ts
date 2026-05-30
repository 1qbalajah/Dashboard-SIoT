const PasswordController = {
    update: {
        form: () => ({
            url: '/settings/password',
            method: 'put' as const,
        }),
    },
};

export default PasswordController;
