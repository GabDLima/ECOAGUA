export function formatLitros(value: number): string {
  const n = Number(value);
  return Number.isInteger(n)
    ? n.toLocaleString('pt-BR')
    : n.toLocaleString('pt-BR', { maximumFractionDigits: 1 });
}

export function formatPercent(value: number): string {
  return Number(value).toLocaleString('pt-BR', { maximumFractionDigits: 1 });
}

export function formatReais(value: number): string {
  return Number(value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}
