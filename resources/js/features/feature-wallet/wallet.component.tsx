import styles from './wallet.module.css';

export type Balance = {
    asset: string;
    free: string;
    locked: string;
    available: string;
    usdt_value: string;
};

type Props = { balances: Balance[] };

export const Wallet = (props: Props) => {
    const { balances } = props;

    return (
        <div className={styles.container}>
            <table className={styles.table}>
                <thead>
                    <tr>
                        <th>asset</th>
                        <th>free</th>
                        <th>locked</th>
                        <th>available</th>
                        <th>value</th>
                    </tr>
                </thead>
                <tbody>
                    {balances.map((b) => (
                        <tr key={b.asset}>
                            <td>{b.asset}</td>
                            <td>{b.free}</td>
                            <td>{b.locked}</td>
                            <td>{b.available}</td>
                            <td>{b.usdt_value}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};
