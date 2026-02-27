import styles from './wallet.module.css';

export type Balance = {
    asset: string;
    free: string;
    locked: string;
    available: string;
};

type Props = { balances: Balance[] };

export const Wallet = (props: Props) => {
    const { balances } = props;

    return (
        <div className={styles.container}>
            <div>
                <div>asset</div>
                <div>free</div>
                <div>locked</div>
                <div>available</div>
            </div>
            {balances.map((b) => (
                <div key={b.asset}>
                    <span>{b.asset}</span>
                    <span>{b.free}</span>
                    <span>{b.locked}</span>
                    <span>{b.available}</span>
                </div>
            ))}
        </div>
    );
};
