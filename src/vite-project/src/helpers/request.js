export function useRequestGenerator(controller, params = []) {
    return [`module=VPSDSSuspensionTable`, `c=${controller}`, `json=1`].concat(params).join("&");
}
