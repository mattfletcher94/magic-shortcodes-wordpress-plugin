interface ShortcodeDetails {
  id: string
  title: string
  attributes: Array<{
    id: string
    name: string
    default: string
  }>
}

export type { ShortcodeDetails }
