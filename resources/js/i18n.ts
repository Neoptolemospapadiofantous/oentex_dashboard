import { createI18n } from 'vue-i18n';
// import messages from '@intlify/vite-plugin-vue-i18n/messages';
import en from '@/locales/en.json';
import ae from '@/locales/ae.json';
import da from '@/locales/da.json';

import de from '@/locales/de.json';
import el from '@/locales/en.json';

import es from '@/locales/es.json';
import fr from '@/locales/fr.json';
// import hu from '@/locales/hu.json';
// import it from '@/locales/it.json';
// import ja from '@/locales/ja.json';
// import pl from '@/locales/pl.json';
// import pt from '@/locales/pt.json';
// import ru from '@/locales/ru.json';
// import en from '@/locales/en.json';
// import en from '@/locales/en.json';
// import en from '@/locales/en.json';

export default createI18n({
    legacy: false,
    allowComposition: true,
    locale: 'en',
    globalInjection: true,
    fallbackLocale: 'en',
    messages: {
        en,
        ae,
        da,
        de,
        el,
        es,
        fr
    },
});
