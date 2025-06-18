<?php

namespace BumpVersion\Tools;

use BumpVersion\Enums\BumpType;

class VersionBuilder
{
    /**
     * The segment to be bumped based on the BumpType.
     * 1 for Major, 2 for Minor, 3 for Patch.
     */
    private readonly int $segment;

    public function __construct(private readonly string $currentVersion,
                                private readonly BumpType $bumpType)
    {
        // Configure the segment based on the bump type.
        $this->segment = $bumpType->segment();
    }

    /**
     * Bump the version based on the current version and the bump type.
     * 
     * @return string  The new version as a string.
     */
    public function bump(): string
    {
        // Set the version segments based on the current version.
        $versionSegments = $this->asArray();
        
        // Update the appropriate segment based on the bump type.
        $versionSegments[$this->segment]++;
        
        // Return the version as a string.
        return implode(separator: '.',
                       array: $this->fillVersion($versionSegments));
    }

    /**
     * Prepare the version based on the current version and the bump type.
     * 
     * @return array<string>  The prepared version as an array.
     */
    private function asArray(): array
    {
        return array_pad(array: explode('.', $this->currentVersion),
                         length: 3,
                         value: 0);
    }

    /**
     * Fill the version segments with zeros after the bumped segment.
     * 
     * @return array<int>  The filled version segments.
     */
    private function fillVersion(array $versionSegments): array
    {
        return array_merge(array_slice($versionSegments, 0, $this->segment + 1),
                           array_fill(0, 2 - $this->segment, 0));
    }
}
