interface ShortcodeDetails {
  id: string
  title: string
  code: string
  attributes: Array<{
    id: string
    name: string
    default: string
  }>
}

export type { ShortcodeDetails }
