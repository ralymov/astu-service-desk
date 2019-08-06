export function asTime(value) {
  if (!value) {
    return value;
  }
  const date = value.split(', ');
  return date.length >= 2 ? date[1] : value;
}

export function asDate(value) {
  if (!value) {
    return value;
  }
  const date = value.split(', ');
  return date.length >= 2 ? date[0] : value;
}

export function getHostName(url) {
  const match = url.match(/:\/\/(www[0-9]?\.)?(.[^/:]+)/i);
  return (match != null && match.length > 2 && typeof match[2] === 'string' && match[2].length > 0)
    ? match[2]
    : null;
}
