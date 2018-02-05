<?php

namespace Mcustiel\PowerRoute\Common\Conditions;

use Psr\Http\Message\ServerRequestInterface;

class AllConditionsMatcher extends AbstractConditionsMatcher implements ConditionsMatcherInterface
{
    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\PowerRoute\Common\Conditions\ConditionsMatcherInterface::conditionsMatches()
     */
    public function matches(array $conditions, ServerRequestInterface $request)
    {
        foreach ($conditions as $condition) {
            $inputSourceData = $this->getInputSource($condition);
            $matcherData = $this->getMatcher($condition);

            $inputValue = $inputSourceData->getInstance()->getValue(
                $request,
                $inputSourceData->getArgument()
            );

            if (!$matcherData->getInstance()->match($inputValue, $matcherData->getArgument())) {
                return false;
            }
        }

        return true;
    }
}
