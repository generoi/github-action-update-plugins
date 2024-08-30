# github-workflows-plugins

### Gravityforms

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/gravityforms-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      slug: 'gravityforms'
```

### FacetWP

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/facetwp-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      slug: 'facetwp'
      host: 'example.com'
```

### EDD / Polylang PRO

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
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

### EDD / Polylang WC

```yyml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/edd-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
    with:
      slug: 'Polylang for WooCommerce'
      source_url: 'https://example.com'
      endpoint_url: 'https://polylang.pro'
```

### Advanced Custom Fields PRO

```yml
name: Build
on:
  workflow_dispatch:
  schedule:
    - cron: '5 4 * * *'
jobs:
  build:
    uses: generoi/github-action-update-plugins/.github/workflows/acf-update.yml@master
    secrets:
      LICENSE_KEY: ${{ secrets.LICENSE_KEY }}
```
