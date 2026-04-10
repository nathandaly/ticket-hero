import type { Auth } from '@/types/auth';

export type DifficultyConfig = {
    label: string;
    color: string;
};

export type HeroConfig = {
    statuses: Record<string, string>;
    difficulties: Record<number, DifficultyConfig>;
};

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            name: string;
            auth: Auth;
            sidebarOpen: boolean;
            hero: HeroConfig;
            [key: string]: unknown;
        };
    }
}
