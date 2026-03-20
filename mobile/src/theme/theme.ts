/**
 * ECOÁGUA – Design System (Mobile)
 *
 * Extraído fielmente do sistema web:
 *   resources/dashboard/css/ux_improvements.css
 *   resources/dashboard/css/dark_mode.css
 *   App/View/site/{dashboard,consumo,metas,login}.php
 *   App/View/includes/site/navbar.php
 *
 * Paleta baseada em Tailwind CSS v3 (mesmos hex codes usados no projeto web).
 */

// ─────────────────────────────────────────────
// CORES
// ─────────────────────────────────────────────

export const colors = {

  // ── Marca / Primária ─────────────────────────
  // Azul-marinho profundo – navbar, headers de cards, botões primários, títulos
  primary:        '#1e3a8a',   // blue-900  → bg da navbar, btn-eco-primary, títulos "text-blue-900"
  primaryHover:   '#1e40af',   // blue-800  → hover de botões primários, gradiente da navbar
  primaryLight:   '#3b82f6',   // blue-500  → focus de inputs, indicadores
  primaryLighter: '#60a5fa',   // blue-400  → dark-mode focus, acentos secundários
  primaryPale:    '#dbeafe',   // blue-100  → eco-card-icon bg (consumo/metas), eco-badge-info bg
  primaryFaint:   '#eff6ff',   // blue-50   → hover de linhas de tabela, stat card bg

  // ── Sucesso / Verde (eco-badge-success, btn-eco-success, eco-progress-success) ──
  success:        '#10b981',   // emerald-500 → btn-eco-success, progress-success start
  successHover:   '#059669',   // emerald-600 → btn-eco-success hover
  successLight:   '#34d399',   // emerald-400 → progress-success end (gradient)
  successPale:    '#d1fae5',   // emerald-100 → eco-badge-success bg, alert-success bg
  successText:    '#065f46',   // emerald-800 → eco-badge-success text
  successBg:      '#f0fdf4',   // green-50   → alerta sucesso fundo
  successBgDark:  '#22543d',   // dark mode bg-green-100

  // ── Perigo / Vermelho (alertas, badges danger, progress danger) ────────────────
  danger:         '#ef4444',   // red-500   → progress-danger start, alertas border
  dangerHover:    '#dc2626',   // red-600   → eco-input-error focus, eco-error-text
  dangerLight:    '#f87171',   // red-400   → progress-danger end (gradient)
  dangerPale:     '#fee2e2',   // red-100   → eco-badge-danger bg
  dangerFaint:    '#fef2f2',   // red-50    → alerta danger fundo (bg-red-50)
  dangerText:     '#991b1b',   // red-800   → eco-badge-danger text
  dangerTextDark: '#b91c1c',   // red-700   → texto de mensagens de erro
  dangerBorder:   '#ef4444',   // red-500   → borda esquerda alertas danger (border-l-4)
  dangerBgDark:   '#742a2a',   // dark mode bg-red-100

  // ── Aviso / Âmbar (eco-badge-warning, progress warning, "Próximo ao Limite") ───
  warning:        '#f59e0b',   // amber-400 → progress-warning start
  warningHover:   '#fbbf24',   // amber-300 → progress-warning end
  warningPale:    '#fef3c7',   // yellow-100 → eco-badge-warning bg
  warningText:    '#92400e',   // amber-900 → eco-badge-warning text
  warningIcon:    '#d37801',   // custom    → icone-dashboard, fa-pen-to-square (style.css)

  // ── Info / Azul claro (eco-badge-info) ────────────────────────────────────────
  info:           '#2563eb',   // blue-600  → eco-badge-info text variant
  infoPale:       '#dbeafe',   // blue-100  → eco-badge-info bg
  infoText:       '#1e40af',   // blue-800  → eco-badge-info text

  // ── Roxo / Projeção (card Projeção, gráficos, histórico) ─────────────────────
  purple:         '#9333ea',   // purple-600 → eco-card-icon text-purple-600
  purplePale:     '#f3e8ff',   // purple-100 → eco-card-icon bg-purple-100
  purpleFaint:    '#faf5ff',   // purple-50  → stat card bg
  purpleDark:     '#581c87',   // purple-900 → texto stat cards roxos

  // ── Cyan / Consumo Diário ─────────────────────────────────────────────────────
  cyan:           '#0891b2',   // cyan-600  → eco-card-icon text-cyan-600
  cyanPale:       '#cffafe',   // cyan-100  → eco-card-icon bg-cyan-100
  cyanFaint:      '#ecfeff',   // cyan-50   → fundo gradiente consumo/metas pages

  // ── Laranja / Meta, Alertas de Consumo ────────────────────────────────────────
  orange:         '#ea580c',   // orange-600 → eco-card-icon text-orange-600
  orangePale:     '#ffedd5',   // orange-100 → eco-card-icon bg-orange-100
  orangeIcon:     '#d37801',   // custom    → icone-dashboard, ícone de edição (style.css)
  spinner:        '#e37202',   // custom    → spinner-grow (custom.css)

  // ── Gráficos Chart.js (azuis escalonados) ─────────────────────────────────────
  chart: {
    blue1: '#1e3c72',  // azul mais escuro (consumo mensal border)
    blue2: '#3c78b4',
    blue3: '#5fa5e5',
    blue4: '#78b4f0',
    blue5: '#91c4ff',
    blue6: '#aad4ff',
    blue7: '#c3e4ff',  // azul mais claro
    red:   'rgba(220, 38, 38, 1)',   // faturas border (red-600)
    redFill: 'rgba(220, 38, 38, 0.1)',
    blueFill: 'rgba(30, 60, 114, 0.1)',
  },

  // ── Neutros / Fundo / Texto ────────────────────────────────────────────────────
  white:          '#ffffff',
  background:     '#f9fafb',   // gray-50   → bg-gray-50 (dashboard body)
  backgroundAlt:  '#f3f4f6',   // gray-100  → thead bg, skeleton
  surface:        '#ffffff',   // cards, inputs, dropdowns
  surfaceHover:   '#eff6ff',   // blue-50   → hover de linhas e menu mobile

  border:         '#e5e7eb',   // gray-200  → eco-input border, divisores
  borderLight:    '#f0f0f0',   // listagem mobile (Consumo histórico)
  borderMedium:   '#d1d5db',   // gray-300

  textPrimary:    '#1f2937',   // gray-800  → valores numéricos grandes dos cards
  textSecondary:  '#374151',   // gray-700  → corpo de tabelas, eco-label
  textMuted:      '#6b7280',   // gray-500  → labels de cards, subtítulos
  textLight:      '#9ca3af',   // gray-400  → eco-empty-icon, placeholder
  textWhite:      '#ffffff',
  textBlueDeep:   '#1e3a8a',   // blue-900  → títulos de seção ("text-blue-900")

  // ── Dark Mode ─────────────────────────────────────────────────────────────────
  dark: {
    background:   '#1a202c',   // gradiente dark start (equivale ao gray-900 Tailwind v2)
    surface:      '#2d3748',   // cards, dropdowns, navbar dark
    surfaceAlt:   '#374151',   // thead dark, input bg dark
    surfaceFocus: '#4a5568',   // input focus bg dark
    border:       '#4a5568',   // borders dark
    textPrimary:  '#e2e8f0',   // texto principal dark
    textSecondary:'#cbd5e0',   // texto secundário dark (gray-600 dark)
    textMuted:    '#a0aec0',   // muted dark (gray-500 dark)
    textDisabled: '#718096',   // inputs disabled/readonly dark
    textBlue:     '#90cdf4',   // blue-900 reescrito para dark
  },

  // ── Formulário Validação (style.css) ──────────────────────────────────────────
  valid:          '#28a745',   // is-valid border
  invalid:        '#dc3545',   // is-invalid border
  whatsapp:       '#0b680b',   // fa-whatsapp (rgb(11,104,11))
  deleteIcon:     '#ff0000',   // fa-trash-can
};

// ─────────────────────────────────────────────
// GRADIENTES
// ─────────────────────────────────────────────

export const gradients = {
  // Navbar (bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900)
  navbar: ['#1e3a8a', '#1e40af', '#1e3a8a'] as const,

  // Login – painel esquerdo animado
  loginPanel: ['#1e3a8a', '#3b82f6', '#60a5fa'] as const, // 135deg

  // Página de consumo e metas – fundo
  pageBg: ['#eff6ff', '#ffffff', '#ecfeff'] as const, // blue-50 → white → cyan-50

  // Dark mode body
  darkBg: ['#1a202c', '#2d3748'] as const, // 135deg

  // Stat cards (fundo de cada estatística rápida)
  statBlue:   '#eff6ff',   // blue-50
  statGreen:  '#f0fdf4',   // green-50
  statPurple: '#faf5ff',   // purple-50
};

// ─────────────────────────────────────────────
// TIPOGRAFIA
// ─────────────────────────────────────────────

export const typography = {
  // Família
  fontFamily: 'System',  // Tailwind default → Inter / system-ui / sans-serif

  // Tamanhos (mapeamento Tailwind → rem → px aproximado)
  fontSize: {
    xs:   12,  // 0.75rem  → eco-badge, help-text, eco-error-text, card labels mobile
    sm:   14,  // 0.875rem → card labels ("text-sm"), help texts, badge fonte
    base: 16,  // 1rem     → btn-eco, eco-input, corpo de texto padrão
    lg:   18,  // 1.125rem → eco-empty-title, btn tamanho médio
    xl:   20,  // 1.25rem  → h3 (mobile), status text
    xl2:  24,  // 1.5rem   → h2 mobile, h3 desktop, títulos de seção
    xl3:  30,  // 1.875rem → h2 desktop, card valores numéricos ("text-3xl")
    xl4:  32,  // 2rem     → h1 mobile
    xl5:  40,  // 2.5rem   → h1 desktop
    xl6:  48,  // 3rem     → logo login "ECOÁGUA" (font-size: 3rem)
    xl8:  80,  // 5rem     → ícone de gota login
    dashboard_icon: 45,  // icone-dashboard (style.css)
  },

  // Pesos
  fontWeight: {
    normal:    '400',
    medium:    '500',   // btn-eco, eco-label, nav-links, card labels
    semibold:  '600',   // h2, tabela header, eco-badge
    bold:      '700',   // h1, logo ECOÁGUA, card valores numéricos, títulos page
  },

  // Line heights
  lineHeight: {
    tight:   1.2,   // h1
    snug:    1.3,   // h2
    normal:  1.4,   // h3
    relaxed: 1.625, // parágrafos de corpo (p { line-height: 1.625 })
  },

  // Tracking (letter-spacing)
  tracking: {
    wide: 0.05,  // "tracking-wide" → logo ECOÁGUA na navbar
  },
};

// ─────────────────────────────────────────────
// ESPAÇAMENTOS
// ─────────────────────────────────────────────

export const spacing = {
  // Base unit: 4px (Tailwind default)
  // Notação: spacing.N = N * 4px

  xs:   4,   // gap miúdo entre chips/ícones
  sm:   8,   // mb-2, padding interno pequeno
  md:   12,  // padding de badge (px-3=12px), gap interno eco-card-icon→texto
  base: 16,  // padding padrão interno (p-4), py-4 em main
  lg:   20,  // padding médio
  xl:   24,  // px-6 (padding horizontal page), p-6 (eco-card desktop), card padding mobile
  xl2:  28,
  xl3:  32,  // gap-8 (gap entre cards no grid), mb-8 (section margin), p-5 do card login (20px → 1.25rem… mas gap-8=32px)
  xl4:  40,  // eco-empty-state padding lateral, pt-10 algumas seções
  xl5:  48,  // pt-20 (main-content top padding para compensar navbar fixa 64px = h-16)

  // Específicos nomeados
  navbarHeight:      64,   // h-16 → navbar fixed height
  pageHorizontal:    24,   // px-6
  pageVertical:      16,   // py-4
  cardPadding:       24,   // eco-card padding: 1.5rem
  cardPaddingMobile: 16,   // eco-card padding mobile: 1rem
  cardIconSize:      56,   // eco-card-icon: 3.5rem (w-3.5)
  cardIconSizeMobile:48,   // eco-card-icon mobile: 3rem
  cardGap:           32,   // gap-8 entre cards no grid
  sectionMargin:     32,   // mb-8 entre seções
  inputPaddingV:     12,   // eco-input padding vertical: 0.75rem
  inputPaddingH:     16,   // eco-input padding horizontal: 1rem
  btnPaddingV:       12,   // btn-eco padding vertical: 0.75rem
  btnPaddingH:       24,   // btn-eco padding horizontal: 1.5rem
  progressHeight:    12,   // eco-progress height: 0.75rem
  badgePaddingV:     4,    // eco-badge padding vertical: 0.25rem
  badgePaddingH:     12,   // eco-badge padding horizontal: 0.75rem
  emptyStatePaddingV:48,   // eco-empty-state padding: 3rem vertical
};

// ─────────────────────────────────────────────
// BORDER RADIUS
// ─────────────────────────────────────────────

export const borderRadius = {
  none:   0,
  xs:     4,    // 0.25rem → eco-skeleton, tooltip
  sm:     6,    // 0.375rem → tooltip border-radius
  md:     8,    // 0.5rem → btn-eco, eco-input, nav-link hover, tabela arredondamento
  lg:     12,   // 0.75rem → progress bars capas internas
  xl:     16,   // 1rem → eco-card principal (border-radius: 1rem)
  full:   9999, // totalmente redondo → eco-badge, eco-progress, eco-card-icon, perfil avatar
  circle: '50%', // eco-card-icon, avatar de perfil (w-8 h-8 rounded-full)
};

// ─────────────────────────────────────────────
// SOMBRAS
// ─────────────────────────────────────────────

export const shadows = {
  // eco-card padrão
  card: {
    shadowColor:    '#000000',
    shadowOffset:   { width: 0, height: 4 },
    shadowOpacity:  0.1,
    shadowRadius:   6,
    elevation:      4,   // Android
  },
  // eco-card hover (equivalente para React Native → usado em estado pressionado)
  cardHover: {
    shadowColor:    '#000000',
    shadowOffset:   { width: 0, height: 20 },
    shadowOpacity:  0.1,
    shadowRadius:   25,
    elevation:      12,
  },
  // Navbar (shadow-lg)
  navbar: {
    shadowColor:    '#000000',
    shadowOffset:   { width: 0, height: 4 },
    shadowOpacity:  0.15,
    shadowRadius:   8,
    elevation:      8,
  },
  // Cards de login (shadow-lg / shadow-2xl)
  login: {
    shadowColor:    '#000000',
    shadowOffset:   { width: 0, height: 10 },
    shadowOpacity:  0.2,
    shadowRadius:   15,
    elevation:      10,
  },
  // Botão primário hover
  btnPrimary: {
    shadowColor:    '#1e3a8a',
    shadowOffset:   { width: 0, height: 10 },
    shadowOpacity:  0.3,
    shadowRadius:   15,
    elevation:      6,
  },
  // Botão success hover
  btnSuccess: {
    shadowColor:    '#10b981',
    shadowOffset:   { width: 0, height: 10 },
    shadowOpacity:  0.3,
    shadowRadius:   15,
    elevation:      6,
  },
  // Dark mode (mais intensa)
  dark: {
    shadowColor:    '#000000',
    shadowOffset:   { width: 0, height: 10 },
    shadowOpacity:  0.5,
    shadowRadius:   15,
    elevation:      8,
  },
};

// ─────────────────────────────────────────────
// COMPONENTES PRÉ-CONFIGURADOS
// (atalhos para StyleSheet.create no app)
// ─────────────────────────────────────────────

export const components = {

  // ── Navbar ────────────────────────────────────────────────────────────────────
  navbar: {
    height:      spacing.navbarHeight,
    background:  colors.primary,       // gradient via LinearGradient
    textColor:   colors.textWhite,
    fontSize:    typography.fontSize.xl2,
    fontWeight:  typography.fontWeight.bold,
    letterSpacing: typography.tracking.wide,
    activeItemBg: 'rgba(255,255,255,0.2)',
    activeItemBorderWidth: 2,
    activeItemBorderColor: colors.white,
  },

  // ── Eco Card ──────────────────────────────────────────────────────────────────
  card: {
    backgroundColor:  colors.surface,
    borderRadius:     borderRadius.xl,   // 16
    padding:          spacing.cardPadding,
    paddingMobile:    spacing.cardPaddingMobile,
    ...shadows.card,
  },

  // ── Ícone do Card ─────────────────────────────────────────────────────────────
  // Círculo colorido com ícone dentro
  cardIcon: {
    size:          spacing.cardIconSize,      // 56
    sizeMobile:    spacing.cardIconSizeMobile, // 48
    borderRadius:  borderRadius.full,
    // variantes de cor (bg + icon):
    blue:    { bg: colors.primaryPale,  icon: colors.primaryLight },
    green:   { bg: colors.successPale,  icon: colors.success },
    purple:  { bg: colors.purplePale,   icon: colors.purple },
    orange:  { bg: colors.orangePale,   icon: colors.orange },
    cyan:    { bg: colors.cyanPale,     icon: colors.cyan },
    gray:    { bg: colors.backgroundAlt, icon: colors.textMuted },
    red:     { bg: colors.dangerFaint,  icon: colors.danger },
    yellow:  { bg: colors.warningPale,  icon: colors.warning },
  },

  // ── Botão Primário (btn-eco-primary) ──────────────────────────────────────────
  btnPrimary: {
    backgroundColor:   colors.primary,
    color:             colors.textWhite,
    borderRadius:      borderRadius.md,   // 8
    paddingVertical:   spacing.btnPaddingV,
    paddingHorizontal: spacing.btnPaddingH,
    fontSize:          typography.fontSize.base,
    fontWeight:        typography.fontWeight.medium,
    alignItems:        'center' as const,
    justifyContent:    'center' as const,
  },

  // ── Botão Success (btn-eco-success) ───────────────────────────────────────────
  btnSuccess: {
    backgroundColor:   colors.success,
    color:             colors.textWhite,
    borderRadius:      borderRadius.md,
    paddingVertical:   spacing.btnPaddingV,
    paddingHorizontal: spacing.btnPaddingH,
    fontSize:          typography.fontSize.base,
    fontWeight:        typography.fontWeight.medium,
  },

  // ── Botão Desabilitado ────────────────────────────────────────────────────────
  btnDisabled: {
    backgroundColor: colors.textLight,  // gray-400 (#9ca3af)
    color:           colors.textWhite,
  },

  // ── Input (eco-input) ─────────────────────────────────────────────────────────
  input: {
    borderWidth:       2,
    borderColor:       colors.border,         // #e5e7eb
    borderRadius:      borderRadius.md,       // 8
    paddingVertical:   spacing.inputPaddingV,  // 12
    paddingHorizontal: spacing.inputPaddingH,  // 16
    fontSize:          typography.fontSize.base,
    color:             colors.textSecondary,
    backgroundColor:   colors.surface,
  },
  inputFocus: {
    borderColor:  colors.primaryLight,  // blue-500 #3b82f6
    // ring: 3px rgba(59,130,246,0.1) → React Native não suporta outline, usar borderColor
  },
  inputError: {
    borderColor:  colors.danger,   // #ef4444
  },
  inputLabel: {
    fontSize:    typography.fontSize.sm,
    fontWeight:  typography.fontWeight.medium,
    color:       colors.textSecondary,  // #374151
    marginBottom: spacing.sm,
  },
  inputHelp: {
    fontSize:   typography.fontSize.xs,
    color:      colors.textMuted,  // #6b7280
    marginTop:  spacing.xs,
  },
  inputErrorText: {
    fontSize:   typography.fontSize.xs,
    color:      colors.dangerHover,  // #dc2626
    marginTop:  spacing.xs,
  },

  // ── Badge (eco-badge) ─────────────────────────────────────────────────────────
  badge: {
    borderRadius:      borderRadius.full,
    paddingVertical:   spacing.badgePaddingV,
    paddingHorizontal: spacing.badgePaddingH,
    fontSize:          typography.fontSize.xs,
    fontWeight:        typography.fontWeight.semibold,
    // Variantes:
    success: { bg: colors.successPale,  text: colors.successText },
    warning: { bg: colors.warningPale,  text: colors.warningText },
    danger:  { bg: colors.dangerPale,   text: colors.dangerText  },
    info:    { bg: colors.infoPale,     text: colors.infoText    },
  },

  // ── Progress Bar (eco-progress) ───────────────────────────────────────────────
  progress: {
    height:        spacing.progressHeight,  // 12
    borderRadius:  borderRadius.full,
    backgroundColor: colors.border,        // #e5e7eb (trilho)
    // Gradientes das barras (use react-native-linear-gradient):
    success: { start: colors.success,  end: colors.successLight },  // #10b981 → #34d399
    warning: { start: colors.warning,  end: colors.warningHover },  // #f59e0b → #fbbf24
    danger:  { start: colors.danger,   end: colors.dangerLight  },  // #ef4444 → #f87171
  },

  // ── Alerta Inline (border-l-4) ────────────────────────────────────────────────
  alert: {
    borderLeftWidth: 4,
    borderRadius:    borderRadius.sm,
    padding:         spacing.base,
    success: {
      bg:          colors.successBg,      // #f0fdf4
      border:      colors.success,         // #10b981
      text:        colors.successText,     // #065f46
    },
    danger: {
      bg:          colors.dangerFaint,    // #fef2f2
      border:      colors.dangerBorder,   // #ef4444
      text:        colors.dangerTextDark, // #b91c1c
    },
    info: {
      bg:          colors.primaryPale,    // #dbeafe
      border:      colors.primaryLight,   // #3b82f6
      text:        colors.infoText,       // #1e40af
    },
  },

  // ── Empty State (eco-empty-state) ─────────────────────────────────────────────
  emptyState: {
    paddingVertical:  spacing.emptyStatePaddingV,  // 48
    alignItems:       'center' as const,
    iconSize:         typography.fontSize.xl8,     // 80 (5rem de font-size do ícone)
    iconColor:        colors.textLight,             // gray-400
    titleFontSize:    typography.fontSize.lg,       // 18
    titleFontWeight:  typography.fontWeight.semibold,
    titleColor:       colors.textSecondary,         // #374151
    textColor:        colors.textMuted,             // #6b7280
    marginBottom:     spacing.lg,                   // 20 entre título e texto
  },

  // ── Loading Spinner ───────────────────────────────────────────────────────────
  spinner: {
    color:  colors.primary,  // #1e3a8a (eco-spinner usa border-top-color: #1e3a8a)
    size:   'large' as const,
  },
};

// ─────────────────────────────────────────────
// TELAS ESPECÍFICAS
// ─────────────────────────────────────────────

export const screens = {

  // ── Login ─────────────────────────────────────────────────────────────────────
  login: {
    // Painel esquerdo (desktop) – não existe no mobile, mas pode ser usado como splash
    leftPanelGradient:  gradients.loginPanel,
    leftPanelAngle:     135,
    // Painel direito (formulário)
    rightPanelBg:       colors.backgroundAlt,   // bg-light = gray-100
    cardBorderRadius:   borderRadius.xl,
    cardPadding:        40,  // p-5 = 1.25rem... mas card-body p-5 = 20px; aqui p-5=20px
    titleText:          'Bem-vindo de volta!',
    titleColor:         colors.primary,            // #1e3a8a
    titleFontSize:      typography.fontSize.xl2,   // 24 → "1.75rem" no web
    subtitleColor:      colors.textMuted,
    logoIconColor:      colors.primaryLight,       // text-blue-600
    logoTextColor:      colors.primary,            // text-blue-900
    forgotLinkColor:    colors.primaryLight,
  },

  // ── Dashboard ─────────────────────────────────────────────────────────────────
  dashboard: {
    pageBackground:     colors.background,          // gray-50
    greetingFontSize:   typography.fontSize.xl2,    // text-2xl = 24
    greetingFontWeight: typography.fontWeight.semibold,
    greetingColor:      colors.textBlueDeep,        // text-blue-900 = #1e3a8a
    // Seção de "Estatísticas Rápidas" (mini cards dentro do card)
    statCardBlue:   { bg: colors.primaryFaint,  text: colors.primary       },
    statCardGreen:  { bg: colors.successBg,     text: '#14532d'             },  // green-900
    statCardPurple: { bg: colors.purpleFaint,   text: colors.purpleDark    },
    // Cabeçalhos de tabela/card com fundo azul
    sectionHeaderBg:    colors.primary,   // bg-blue-900
    sectionHeaderText:  colors.white,
    // Tabela
    tableHeaderBg:      colors.backgroundAlt,  // bg-gray-100
    tableRowHoverBg:    colors.primaryFaint,   // hover:bg-blue-50
    tableBorderColor:   colors.border,         // divide-gray-200
  },

  // ── Consumo ───────────────────────────────────────────────────────────────────
  consumo: {
    pageBackground:    colors.background,
    // Gradiente bg-gradient-to-br from-blue-50 via-white to-cyan-50
    pageBgGradient:    gradients.pageBg,
    titleFontSize:     typography.fontSize.xl3,    // text-3xl = 30
    titleFontWeight:   typography.fontWeight.bold,
    titleColor:        colors.textPrimary,         // text-gray-800
    // Seção de metas exibida dentro da tela de consumo
    metasBgGradient:   [colors.primaryFaint, colors.cyanFaint] as const,
    metasBorder:       colors.primaryPale,
  },

  // ── Metas ─────────────────────────────────────────────────────────────────────
  metas: {
    pageBackground:    colors.background,
    pageBgGradient:    gradients.pageBg,
    titleFontSize:     typography.fontSize.xl3,    // text-3xl
    titleFontWeight:   typography.fontWeight.bold,
    titleColor:        colors.textPrimary,
    // Status Badge colors
    statusWithinGoal:  colors.success,             // "Dentro da Meta" → green-600
    statusNearLimit:   colors.warning,             // "Próximo ao Limite" → yellow-600
    statusOverGoal:    colors.danger,              // "Acima da Meta" → red-600
    // Card de alerta de meta atingida (90%)
    alertBg:           colors.dangerFaint,
    alertBorderColor:  colors.danger,
    alertText:         colors.dangerTextDark,
    // Card de sucesso (ainda dentro da meta)
    successInfoBg:     colors.successBg,
    successInfoBorder: colors.success,
    successInfoText:   colors.successText,
    // Categoria colors (dots na tabela de categorias)
    categoryColors:    [
      colors.chart.blue1,
      '#3c78b4',
      '#5fa5e5',
      '#78b4f0',
      '#91c4ff',
    ],
  },
};

// ─────────────────────────────────────────────
// ANIMAÇÕES (referência para Animated API / Reanimated)
// ─────────────────────────────────────────────

export const animations = {
  // fadeIn (animate-fade-in) – usado em eco-cards ao entrar na tela
  fadeIn: {
    duration:  500,   // 0.5s
    easing:    'ease-out',
    fromY:     20,    // translateY de 20px → 0
    fromOpacity: 0,
  },
  // Card hover uplift
  cardHover: {
    translateY: -4,
    duration:   300,
  },
  // Slide in from right (animate-slide-in-right) – alertas
  slideInRight: {
    duration:   300,
    fromX:      '100%',
  },
  // Shimmer da progress bar
  shimmer: {
    duration: 2000,
    loop:     true,
  },
  // Pulse suave (animate-pulse-soft)
  pulseSoft: {
    duration:        2000,
    opacityMin:      0.8,
    opacityMax:      1.0,
    loop:            true,
  },
  // Skeleton loading
  skeleton: {
    duration:  1500,
    loop:      true,
  },
  // Transition geral de tema / inputs / backgrounds
  themeTransition: {
    duration: 300,
  },
  // Atraso entre cards (stagger)
  cardStagger: 100,  // ms por card (0s, 0.1s, 0.2s, 0.3s...)
};

// ─────────────────────────────────────────────
// EXPORT DEFAULT CONSOLIDADO
// ─────────────────────────────────────────────

const theme = {
  colors,
  gradients,
  typography,
  spacing,
  borderRadius,
  shadows,
  components,
  screens,
  animations,
};

export default theme;
