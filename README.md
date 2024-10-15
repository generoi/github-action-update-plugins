# github-workflows-plugins

## Plugin examples

### Gravityforms

<details>
<summary>Gravityforms</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/gravityforms-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      slug: 'gravityforms'
```

</details>

<details>
<summary>Gravity Forms Add-Ons</summary>

Use the `slug` input to change which add-on you would like to pull.

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/gravityforms-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      slug: gravityformswebhooks
```
</details>

### FacetWP

<details>
<summary>FacetWP</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/facetwp-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      slug: 'facetwp'
      host: 'example.com'
```

</details>

<details>
<summary>FacetWP - Multilingual support</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/facetwp-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      slug: 'facetwp-i18n'
      host: 'example.com'
```

</details>

### EDD plugins

_Note that a license need to be manually activated before it's available for downloading new versions. Happy to accept a PR that activates it automatically but for now it's a manual step._

<details>
<summary>Polylang PRO</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/edd-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      slug: 'Polylang Pro'
      source_url: 'https://example.com'
      endpoint_url: 'https://polylang.pro'
```

</details>

<details>
<summary>Polylang for WooCommerce</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/edd-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      slug: 'Polylang for WooCommerce'
      source_url: 'https://example.com'
      endpoint_url: 'https://polylang.pro'
      changelog_extract: >-
        '/[0-9\\.]+ \\(.*\\)/ { if (p) { exit }; if ($1 == ver) { p=1; next } } p && NF'
```

</details>
<details>

<summary>WP All Import</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/edd-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      method: 'GET'
      slug: 'WP All Import'
      source_url: 'https://example.com'
      endpoint_url: 'https://update.wpallimport.com/check_version'
```

</details>

### Advanced Custom Fields

<details>
<summary>Advanced Custom Fields PRO</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/acf-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
```

</details>

### WooCommerce.com

You can retrieve the needed access tokens with `wp option get woocommerce_helper_data`

<details>
<summary>WooCommerce Subscriptions</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/wccom-update.yml@master
    secrets:
      ACCESS_TOKEN: ${{ secrets.WCCOM_ACCESS_TOKEN }}
      ACCESS_TOKEN_SECRET: ${{ secrets.WCCOM_ACCESS_TOKEN_SECRET }}
    with:
      slug: 'woocommerce-subscriptions'
```

</details>

<details>
<summary>WooCommerce Product Add-Ons</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/wccom-update.yml@master
    secrets:
      ACCESS_TOKEN: ${{ secrets.WCCOM_ACCESS_TOKEN }}
      ACCESS_TOKEN_SECRET: ${{ secrets.WCCOM_ACCESS_TOKEN_SECRET }}
    with:
      slug: 'woocommerce-product-addons'
```

</details>

<details>
<summary>WooCommerce Gift Cards</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/wccom-update.yml@master
    secrets:
      ACCESS_TOKEN: ${{ secrets.WCCOM_ACCESS_TOKEN }}
      ACCESS_TOKEN_SECRET: ${{ secrets.WCCOM_ACCESS_TOKEN_SECRET }}
    with:
      slug: 'woocommerce-gift-cards'
```

</details>

<details>
<summary>WooCommerce Request a Quote</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/wccom-update.yml@master
    secrets:
      ACCESS_TOKEN: ${{ secrets.WCCOM_ACCESS_TOKEN }}
      ACCESS_TOKEN_SECRET: ${{ secrets.WCCOM_ACCESS_TOKEN_SECRET }}
    with:
      slug: 'woocommerce-request-a-quote'
```

</details>

<details>
<summary>WooCommerce all Products for Subscriptions</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/wccom-update.yml@master
    secrets:
      ACCESS_TOKEN: ${{ secrets.WCCOM_ACCESS_TOKEN }}
      ACCESS_TOKEN_SECRET: ${{ secrets.WCCOM_ACCESS_TOKEN_SECRET }}
    with:
      slug: 'woocommerce-all-products-for-subscriptions'
```

</details>

<details>
<summary>Role Based Pricing for WooCommerce</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/wccom-update.yml@master
    secrets:
      ACCESS_TOKEN: ${{ secrets.WCCOM_ACCESS_TOKEN }}
      ACCESS_TOKEN_SECRET: ${{ secrets.WCCOM_ACCESS_TOKEN_SECRET }}
    with:
      slug: 'role-based-pricing-for-woocommerce'
```

</details>


### WPML

<details>
<summary>Sitepress Multilingual CMS (wpml.org)</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/wpml-update.yml@master
    secrets:
      USER_ID: ${{ secrets.USER_ID }}
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      slug: 'sitepress-multilingual-cms'
```

</details>

<details>
<summary>WPML String Translation (wpml.org)</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/wpml-update.yml@master
    secrets:
      USER_ID: ${{ secrets.USER_ID }}
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      slug: 'wpml-string-translation'
```

</details>

### Markup.fi

<details>
<summary>WooCommerce Carrier Agents / Notuopistehaku</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/markup-update.yml@master
    with:
      slug: 'woocommerce-noutopistehaku'
      source_url: https://example.com
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
```

</details>

<details>
<summary>Woo Printables / Woo Kuitti</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/markup-update.yml@master
    with:
      slug: 'woocommerce-kuitti'
      source_url: https://example.com
      changelog_awk_extract: |
        '/[0-9\.]+ \(.*\)/ { if (p) { exit }; if ($1 == ver) { p=1; next } } p && NF' changelog.txt
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
```

</details>

<details>
<summary>WC Smartship / WooCommerce Smartship Prinetti</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/markup-update.yml@master
    with:
      slug: 'woocommerce-smartship-prinetti'
      source_url: https://example.com
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
```

</details>

<details>
<summary>WC Paytrail (public repository)</summary>

- [Public repository](https://github.com/generoi/wc-paytrail)
- [Official site](https://markup.fi/products/woocommerce-paytrail/)

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/markup-update.yml@master
    with:
      slug: 'woocommerce-paytrail'
```

</details>

### MultilingualPress

<details>
<summary>MultilingualPress</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/multilingualpress-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      instance: '...'
      product_id: '...'
```

</details>

### Beaver Builder

<details>
<summary>Beaver Builder</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/beaver-builder-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      bb_package: bb-plugin-standard # or bb-plugin-agency, bb-plugin-developer, bb-plugin-pro, bb-theme, bb-theme-builder, bb-theme-child
```

</details>

### Manual package retrieval examples

<details>

<summary>WooCommerce Gateway Verifone (zip within a zip)</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    name: Update plugin
    runs-on: ubuntu-latest
    permissions:
      contents: write
    outputs:
      updated: ${{ steps.update.outputs.updated }}
      version: ${{ steps.update.outputs.version }}
    steps:
      - name: Checkout Repository
        uses: actions/checkout@v4

      - name: Retrieve the latest version number
        run: |
          curl https://www.bluecommerce.fi/wp-content/uploads/verifone_modules/woocommerce/verifone-plugin_woocommerce.zip?ver_time=$(date +%s) > wrapper.zip
          unzip -p wrapper.zip verifone-plugin_woocommerce/woocommerce-gateway-verifone.zip > package.zip
          {
            echo 'LATEST_VERSION<<EOF'
            unzip -p package.zip woocommerce-gateway-verifone/woocommerce-gateway-verifone.php | grep 'Version:' | sed 's/.*: //'
            echo 'EOF'
          } >> "$GITHUB_ENV"
          rm wrapper.zip
          mv package.zip /tmp/package.zip


      - name: Update repo
        uses: generoi/github-action-update-plugins@master
        id: update
        with:
          download_path: /tmp/package.zip
          version: ${{ env.LATEST_VERSION }}
          changelog_extract: |
            awk -v ver=${{ env.LATEST_VERSION }} '/^## / { if (p) { exit }; if ($2 == "["ver"]") { p=1; next } } p && NF' CHANGELOG.md

```

</details>


<details>
<summary>Kinsta Must-use Plugins (public repository)</summary>

- [Public repository](https://github.com/generoi/kinsta-mu-plugins)
- [Official site](https://kinsta.com/docs/wordpress-hosting/kinsta-mu-plugin/)

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    name: Update plugin
    runs-on: ubuntu-latest
    permissions:
      contents: write
    outputs:
      updated: ${{ steps.update.outputs.updated }}
      version: ${{ steps.update.outputs.version }}
    steps:
      - name: Checkout Repository
        uses: actions/checkout@v4

      - name: Retrieve the latest version number
        run: |
          curl "https://kinsta.com/kinsta-tools/kinsta-mu-plugins.zip" > package.zip
          {
            echo 'LATEST_VERSION<<EOF'
            unzip -p package.zip kinsta-mu-plugins.php | grep 'Version:' | sed 's/.*: //'
            echo 'EOF'
          } >> "$GITHUB_ENV"
          rm package.zip

      - name: Update repo
        uses: generoi/github-action-update-plugins@master
        id: update
        with:
          download_url: "https://kinsta.com/kinsta-tools/kinsta-mu-plugins.zip"
          version: ${{ env.LATEST_VERSION }}
          strip_archive_folder: 'false'
```

</details>

<details>
<summary>Relevanssi PRO</summary>

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    name: Update plugin
    runs-on: ubuntu-latest
    permissions:
      contents: write
    outputs:
      updated: ${{ steps.update.outputs.updated }}
      version: ${{ steps.update.outputs.version }}
    steps:
      - name: Checkout Repository
        uses: actions/checkout@v4

      - name: Retrieve the latest version number
        run: |
          curl "https://www.relevanssi.com/update/fetch_latest_version.php?api_key=${{ secrets.LICENSE_KEY }}" --output package.zip
          {
            echo 'LATEST_VERSION<<EOF'
            unzip -p package.zip relevanssi-premium/relevanssi.php | grep 'Version:' | sed 's/.*: //'
            echo 'EOF'
          } >> "$GITHUB_ENV"
          rm package.zip

      - name: Update repo
        uses: generoi/github-action-update-plugins@master
        id: update
        with:
          download_url: "https://www.relevanssi.com/update/get_version.php?api_key=${{ secrets.LICENSE_KEY }}&version=${{ env.LATEST_VERSION }}"
          version: ${{ env.LATEST_VERSION }}
          changelog_extract: |
            awk -v ver=${{ env.LATEST_VERSION }} '/^= / { if (p) { exit }; if ($2 == ver) { p=1; next } } p && NF' readme.txt 2>&1
```

</details>

## Automatically rebuild a satis repository

See [generoi/packagist](https://github.com/generoi/packagist) for an example.

1. Add a [job to rebuild satis](https://github.com/generoi/packagist/blob/master/.github/workflows/satis.yml).
1. Add a [job called to trigger the rebuild](https://github.com/generoi/packagist/blob/master/.github/workflows/update.yml)
1. Add a job to each repository to trigger the job after a package has been updated

```yaml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
permissions:
  contents: write
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/acf-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
  update-satis:
    needs: build
    if: needs.build.outputs.updated == 'true'
    uses: generoi/packagist/.github/workflows/update.yml@master
    secrets:
      token: ${{ secrets.PACKAGIST_UPDATE_PAT }}
```
