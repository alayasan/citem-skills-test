/// <reference types="vitest" />
/// <reference types="vitest/globals" />
/// <reference types="@vue/test-utils" />
/// <reference types="jsdom" />

declare module 'vitest' {
  export const describe: any;
  export const it: any;
  export const expect: any;
  export const beforeEach: any;
  export const afterEach: any;
  export const vi: any;
}

declare module '@vue/test-utils' {
  export const mount: any;
  export const shallowMount: any;
  export const createLocalVue: any;
}
