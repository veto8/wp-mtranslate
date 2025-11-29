async function domain_translate_init() {
  await domain_translate_object.init();
}
const domain_translate_object = {
  domain: "",
  base_domain: "",
  domains: [],
  cookie: "googtrans",
  async init() {
    const trans_lang =
      "/" +
      domain_translate_data.source_lang_code +
      "/" +
      domain_translate_data.target_lang_code;

    this.domain = domain_translate_data.domain;
    this.base_domain = domain_translate_data.base_domain;
    this.domains = domain_translate_data.domains;

    if (trans_lang) {
      const cookie_value = await this.get_cookie_value(this.cookie);
      if (cookie_value != trans_lang) {
        await this.delete_cookies("googtrans", this.domain, this.base_domain);
        await this.set_cookie(this.cookie, trans_lang, 60, this.domain);
        let translate = new google.translate.TranslateElement(
          {
            pageLanguage: domain_translate_data.source_lang_code,
            includedLanguages: Object.values(this.domains).join(","),
            autoDisplay: false,
            multilanguagePage: true,
          },
          "google_translate_element",
        );
      } else {
        let translate = new google.translate.TranslateElement(
          {
            pageLanguage: domain_translate_data.source_lang_code,
            includedLanguages: Object.values(this.domains).join(","),
            autoDisplay: false,
            multilanguagePage: true,
          },
          "google_translate_element",
        );
      }
    }
  },

  async delete_cookies(name, domain, base_domain) {
    //console.log(`...try to delete name: ${name}, domain:  ${domain}`);
    document.cookie =
      "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=." +
      base_domain +
      "; path=/";
    try {
      await cookieStore.delete({
        name: name,
        domain: domain,
      });
      await cookieStore.delete({
        name: name,
        domain: base_domain,
      });
    } catch (error) {
      //console.log(`...error deleting cookie: ${error}`);
    }

    cookieNames = (await cookieStore.getAll())
      .map((cookie) => cookie.name)
      .join(" ");
    //console.log(`...cookies remaining: ${cookieNames}`);
  },

  async get_cookie_value(name) {
    const cookie = await cookieStore.get(name);
    let cookie_value = "";
    if (cookie) {
      if (Object.hasOwn(cookie, "value")) {
        cookie_value = cookie.value;
      }
    }
    return cookie_value;
  },

  async set_cookie(c_name, c_value, exp_days, domain) {
    //console.log("...set new cookie to:" + c_value);
    //console.log(domain);
    try {
      await cookieStore.set({
        name: c_name,
        value: c_value,
        domain: domain,
        sameSite: "strict",
        path: "/",
        expires: Date.now() + 60 * 24 * 60 * 60 * 1000,
      });
    } catch (error) {
      //      console.log(`Error setting cookie1: ${error}`);
    }
  },
};
