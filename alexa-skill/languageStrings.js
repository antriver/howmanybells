/* *
 * We create a language strings object containing all of our strings.
 * The keys for each string will then be referenced in our code, e.g. handlerInput.t('WELCOME_MSG').
 * The localisation interceptor in index.js will automatically choose the strings
 * that match the request's locale.
 * */

module.exports = {
    en: {
        translation: {
            WELCOME_MSG: `What do you want to know the price of?`,
            ERROR_MSG: `Sorry, I don't understand what you're asking for.`,
            HELP_MSG: `Tell me the name of something in Animal Crossing New Horizons and I'll tell you how many bells you can sell it for.`,
            GOODBYE_MSG: `Goodbye!`,
            REFLECTOR_MSG: `You just triggered {{intentName}}`,
        }
    },
}
