export function useRequestGenerator(controller, params = []) {
    return [`api/addonmodules.php?module=VPSDSSuspensionTable`, `c=${controller}`, `json=1`].concat(params).join("&");
}
