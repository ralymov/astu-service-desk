export function normalizeDate(date) {
    if ( typeof date === 'string' && (date !== '' )) {
        return new Date(date).toLocaleString("ru");
    }
}
