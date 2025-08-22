export default () => {
    const currencyOptions = {
        style: 'currency',
        currency: 'BRL',
    };

    const toCurrency = (value) => new Intl.NumberFormat('pt-BR', currencyOptions).format(unformattedValue(value));

    const unformattedValue = (value) => {
        let numericValue  = value;

        if (typeof value === 'string') {
            numericValue = parseFloat(value.replace(/[^0-9]/g, '')) / 100;
        }

        if (isNaN(numericValue)) {
            return '';
        }

        return numericValue;
    };

    return {
        toCurrency,
        unformattedValue,
    };
};
