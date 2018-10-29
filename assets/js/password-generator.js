((w, d) => {
    "use strict";

    const passwordGenerator = () => {
        const length = 20;

        const symbols = {
            numbers: '0123456789',
            letters: {
                lowercase: 'abcdefghijklmnopqrstuvwxyz',
                uppercase: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            },
            special: '~!@#$%^&*()_-+=',
            text: '.,:;?/\\|<>[]{}`\'"№',
        };

        const characters = `${symbols.numbers}${symbols.letters.lowercase}${symbols.letters.uppercase}${symbols.special}${symbols.text}`;

        let i = 0, symbol, random, prevRandom = 0, password = '', charsLength = characters.length;

        while (i < length) {
            random = Math.floor(Math.random() * charsLength);
            symbol = characters[random];

            if (length <= charsLength && password !== '' && password.indexOf(symbol) !== -1) {
                continue;
            }

            if (prevRandom !== random) {
                password += symbol;
                i++;
            }

            prevRandom = random;
        }

        console.log(password);

    };

    d.addEventListener('DOMContentLoaded', () => {
        passwordGenerator();
    });

})(window, document);
