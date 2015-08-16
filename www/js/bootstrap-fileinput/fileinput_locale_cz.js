/*!
 * FileInput Czech Translations
 *
 * This file must be loaded after 'fileinput.js'. Patterns in braces '{}', or
 * any HTML markup tags in the messages must not be converted or translated.
 *
 * @see http://github.com/kartik-v/bootstrap-fileinput
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */

(function ($) {
    "use strict";

    $.fn.fileinputLocales['cz'] = {
        fileSingle: 'soubor',
        filePlural: 'soubory',
        browseLabel: 'Vybrat',
        removeLabel: 'Odstranit',
        removeTitle: 'Vyčistit vybrané soubory',
        cancelLabel: 'Storno',
        cancelTitle: 'Přerušit nahrávání',
        uploadLabel: 'Nahrát',
        uploadTitle: 'Nahrát vybrané soubory',
        msgZoomTitle: 'zobrazit podrobnosti',
        msgZoomModalHeading: 'Detailní náhled',
        msgSizeTooLarge: 'Soubor "{name}" (<b>{size} KB</b>): překročena maximální povolená velikost <b>{maxSize} KB</b>.',
        msgFilesTooLess: 'MusĂ­te vybrat nejmĂ©nÄ› <b>{n}</b> {files} pro nahrĂˇnĂ­.',
        msgFilesTooMany: 'PoÄŤet vybranĂ˝ch souborĹŻ pro nahrĂˇnĂ­ <b>({n})</b>: pĹ™ekroÄŤenĂ­ - maximĂˇlnĂ­ povolenĂ˝ limit <b>{m}</b>.',
        msgFileNotFound: 'Soubor "{name}" nebyl nalezen!',
        msgFileSecured: 'ZabezpeÄŤenĂ­ souboru znemoĹľnilo ÄŤĂ­st soubor "{name}".',
        msgFileNotReadable: 'Soubor "{name}" nenĂ­ ÄŤitelnĂ˝.',
        msgFilePreviewAborted: 'NĂˇhled souboru byl pĹ™eruĹˇen pro "{name}".',
        msgFilePreviewError: 'Nastala chyba pĹ™i naÄŤtenĂ­ souboru "{name}".',
        msgInvalidFileType: 'NeplatnĂ˝ typ souboru "{name}". Pouze "{types}" souborĹŻ jsou podporovĂˇny.',
        msgInvalidFileExtension: 'NeplatnĂˇ extenze souboru "{name}". Pouze "{extensions}" souborĹŻ jsou podporovĂˇny.',
        msgValidationError: 'Chyba nahrĂˇnĂ­ souboru.',
        msgLoading: 'Nahrávání souboru {index} z {files} &hellip;',
        msgProgress: 'Nahrávání souboru {index} z {files} - {name} - {percent}% dokončeno.',
        msgSelected: '{n} {files} vybrano',
        msgFoldersNotAllowed: 'TĂˇhni a pusĹĄ pouze soubory! VynechanĂ© {n} pustÄ›nĂ© sloĹľk(y).',
        msgImageWidthSmall: 'Ĺ Ă­Ĺ™ka image soubor "{name}", musĂ­ bĂ˝t alespoĹ? {size} px.',
        msgImageHeightSmall: 'VĂ˝Ĺˇka image soubor "{name}", musĂ­ bĂ˝t alespoĹ? {size} px.',
        msgImageWidthLarge: 'Ĺ Ă­Ĺ™ka obrazovĂ©ho souboru "{name}" nelze pĹ™ekroÄŤit {size} px.',
        msgImageHeightLarge: 'VĂ˝Ĺˇka obrazovĂ©ho souboru "{name}" nelze pĹ™ekroÄŤit {size} px.',
        dropZoneTitle: 'TĂˇhni a pusĹĄ soubory sem &hellip;',
        fileActionSettings: {
            removeTitle: 'Odstranit soubor',
            uploadTitle: 'nahrĂˇt soubor',
            indicatorNewTitle: 'JeĹˇtÄ› nenahrĂˇl',
            indicatorSuccessTitle: 'NahranĂ˝',
            indicatorErrorTitle: 'NahrĂˇt Chyba',
            indicatorLoadingTitle: 'NahrĂˇvĂˇnĂ­ ...'
        }
    };
})(window.jQuery);