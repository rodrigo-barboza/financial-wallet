import { toast as toastService } from 'vue3-toastify';

export default () => {
    const defaultOptions = {
        type: 'default',
        dangerouslyHTMLString: true,
        position: 'bottom-right',
    };

    const toast = {
        default: (message, options = null) => {
            toastService(message, options || defaultOptions);
        },

        success: (message, options = null) => {
            toastService.success(message, options || defaultOptions);
        },

        error: (message, options = null) => {
            toastService.error(message, options || defaultOptions);
        },

        info: (message, options = null) => {
            toastService.info(message, options || defaultOptions);
        },

        warning: (message, options = null) => {
            toastService.warning(message, options || defaultOptions);
        },
    };

    return toast;
};
