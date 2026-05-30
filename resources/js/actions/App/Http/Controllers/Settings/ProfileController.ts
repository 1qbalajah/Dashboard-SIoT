const ProfileController = {
    update: {
        form: () => ({
            url: '/settings/profile',
            method: 'patch' as const,
        }),
    },
    destroy: {
        form: () => ({
            url: '/settings/profile',
            method: 'delete' as const,
        }),
    },
};

export default ProfileController;
