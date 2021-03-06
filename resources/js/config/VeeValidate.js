const validate = {
	custom: {
        // DISPLAYS CUSTOM MESSAGE FOR passwordConfirm
		passwordConfirm: {
            confirmed: 'Passwords do not match.',
        },
        passwordCurrent: {
            required: 'Password field is required',
            alpha_num: 'Password can contain only alpha-numeric characters.',
            min: 'Password should contain at least 6 characters',
        },
        passwordNew: {
            required: 'New password field is required',
            alpha_num: 'New password can contain only alpha-numeric characters.',
            min: 'New password should contain at least 6 characters',
        },
        answer: {
            required: 'All answer fields are required.',
        },
        username: {
            regex: 'Username can contain only letters, numbers and underscores.',
        },
        password: {
            regex: 'Password can contain only letters and numbers.',
        },
        current: {
            regex: 'Current password should contain only letters and numbers.',
            required: 'Current password field is required.',
        },
        new: {
            regex: 'New password should contain only letters and numbers.',
            required: 'New password field is required.',
        },
        confirm: {
            required: 'Password confirmation field is required.',
        },
	}
};

export default validate;
