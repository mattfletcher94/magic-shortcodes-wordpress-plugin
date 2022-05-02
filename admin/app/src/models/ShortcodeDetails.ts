interface ShortcodeDetails {
  id: string
  title: string
  code: string
  attributes: Array<{
    id: string
    name: string
    type: 'custom' | 'post_title'
    default: string
  }>
}

export type { ShortcodeDetails }
