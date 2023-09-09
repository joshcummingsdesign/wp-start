/**
 * Scale a number given a set of ranges.
 * ```
 * (5, [0, 10], [-50, 50]) => 0
 * (-1, [-20, 0], [-100, 100]) => 90
 *```
 *
 * @unreleased
 */
export const scale = (input: number, inputRange: number[], outputRange: number[]): number => {
    const scaledValue =
        ((input - inputRange[0]) * (outputRange[1] - outputRange[0])) / (inputRange[1] - inputRange[0]) +
        outputRange[0];

    if (outputRange[0] < outputRange[1]) {
        return Math.max(Math.min(scaledValue, outputRange[1]), outputRange[0]);
    }

    return Math.max(Math.min(scaledValue, outputRange[0]), outputRange[1]);
};
