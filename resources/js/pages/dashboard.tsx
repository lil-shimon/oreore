import { Head } from '@inertiajs/react';
import { Wallet } from '@/features/feature-wallet/wallet.component';
import type { Balance } from '@/features/feature-wallet/wallet.component';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
];

export default function Dashboard({ balances }: { balances: Balance[] }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <Wallet balances={balances} />
        </AppLayout>
    );
}
