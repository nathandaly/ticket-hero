import { Link, usePage } from '@inertiajs/react';
import { type PropsWithChildren } from 'react';

const navItems = [
    { href: '/board', label: 'Board' },
    { href: '/tickets/create', label: 'Create Ticket' },
    { href: '/leaderboard', label: 'Leaderboard' },
    { href: '/about', label: 'About' },
];

export default function AppLayout({ children }: PropsWithChildren) {
    const { url } = usePage();

    return (
        <div className="min-h-screen bg-background">
            <nav className="border-b bg-card">
                <div className="mx-auto flex h-14 max-w-5xl items-center gap-6 px-4">
                    <Link href="/" className="text-lg font-semibold tracking-tight">
                        Ticket Hero
                    </Link>
                    <div className="flex gap-4">
                        {navItems.map((item) => (
                            <Link
                                key={item.href}
                                href={item.href}
                                className={`text-sm font-medium transition-colors hover:text-primary ${
                                    url.startsWith(item.href)
                                        ? 'text-primary'
                                        : 'text-muted-foreground'
                                }`}
                            >
                                {item.label}
                            </Link>
                        ))}
                    </div>
                </div>
            </nav>
            <main className="mx-auto max-w-5xl px-4 py-8">{children}</main>
        </div>
    );
}
