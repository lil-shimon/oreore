import styles from './wallet.module.css';

export type Balance = {
    asset: string;
    available: string;
    locked: string;
    usdt_value: number;
    usdt_value_prev: number;
    usdt_value_diff: number;
    usdt_value_diff_pct: number | null;
};

type Props = { balances: Balance[] };

const formatDiff = (diff: number, pct: number | null): string => {
    const sign = diff >= 0 ? '+' : '';
    const pctStr = pct !== null ? ` (${sign}${pct.toFixed(2)}%)` : '';
    return `${sign}${diff.toFixed(2)}${pctStr}`;
};

export const Wallet = (props: Props) => {
    const { balances } = props;

    return (
        <div className={styles.container}>
            <table className={styles.table}>
                <thead>
                    <tr>
                        <th>asset</th>
                        <th>available</th>
                        <th>locked</th>
                        <th>value (USDT)</th>
                        <th>diff (24h)</th>
                    </tr>
                </thead>
                <tbody>
                    {balances.map((b) => (
                        <tr key={b.asset}>
                            <td>{b.asset}</td>
                            <td>{b.available}</td>
                            <td>{b.locked}</td>
                            <td>{b.usdt_value.toFixed(2)}</td>
                            <td
                                className={
                                    b.usdt_value_diff >= 0
                                        ? styles.positive
                                        : styles.negative
                                }
                            >
                                {b.usdt_value_prev > 0
                                    ? formatDiff(
                                          b.usdt_value_diff,
                                          b.usdt_value_diff_pct,
                                      )
                                    : '-'}
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};
