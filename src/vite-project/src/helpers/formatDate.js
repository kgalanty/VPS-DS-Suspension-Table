export function formatDate(dateObj) {
    let date = new Date(dateObj);
    const month = date.getMonth() + 1;
    const dateFormatted = date.getFullYear() + '-' + (month<10 ? "0"+month : month) + '-' + date.getDate()

    return dateFormatted
}

export function formatDateShort(dateObj) {
    let date = new Date(dateObj);
    const month = date.getMonth() + 1;
    const dateFormatted = date.getDate() + '/' + (month<10 ? "0"+month : month)
    return dateFormatted
}

export function addDays(dateObj, days)
{
    var date = new Date(dateObj);
    date.setDate(date.getDate() + days);
    return date;
}

export function currentDateTime()
{
    return new Date().toISOString().slice(0, 19).replace('T', ' ')
}